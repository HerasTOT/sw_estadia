<?php

namespace App\Http\Controllers;

use App\Models\Proposals;
use App\Http\Requests\StoreProposalsRequest;
use App\Http\Requests\UpdateProposalsRequest;
use App\Models\announcement_assestment_criteria;
use App\Models\Announcements;
use App\Models\announcements_document_supporting;
use App\Models\Areas_knowledge;
use App\Models\Assestment_Criteria;
use App\Models\Criterias;
use App\Models\Document_Supporting;
use App\Models\Proceedings;
use App\Models\proposals_user;
use App\Models\ProposalStates;
use App\Models\recognitions;
use App\Models\review;
use App\Models\User;
use App\Notifications\ReviewerAssigned;
use App\Notifications\WorkReviewed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use File;


class ProposalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private string $routeName;
    private Proposals $model;
    private string $module = 'proposals';

    public function __construct()
    {
        /*         $this->middleware('auth');
 */
        $this->model = new Proposals();
        $this->routeName = 'proposals.';

        /*   $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
         $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
         $this->middleware("permission:{$this->module}.update")->only(['update', 'edit']);
         $this->middleware("permission:{$this->module}.delete")->only(['destroy', 'edit']);  */
    }

    public function index(Request $request): Response
    {
        $records = new Proposals();
        $user = User::find(Auth::user()->id);

        if ($user->hasRole('Admin')) {

            return Inertia::render("Proposals/Index", [
                'titulo'      => 'Propuestas',
                'records'    => $records->with('users')->paginate(4)->withQueryString(),
                'routeName'      => $this->routeName,
                'state'      => ProposalStates::all(),
                'loadingResults' => false,
            ]);
        } else if ($user->hasRole('Postulante')) {
            $records =  $records->where('user_id', $user->id);

            return Inertia::render("Proposals/Index", [
                'titulo'      => 'Tus Propuestas',
                'records'    => $records->paginate(4)->withQueryString(),
                'routeName'      => $this->routeName,
                'state'      => ProposalStates::all(),
                'loadingResults' => false,
            ]);
        } else {
            $records = $user->proposals();
            $reviews =  review::where('user_id', $user->id)->get();

            return Inertia::render("Proposals/Index", [
                'titulo'      => 'Tus Propuestas',
                'records'    => $records->paginate(4)->withQueryString(),
                'routeName'      => $this->routeName,
                'state'      => ProposalStates::all(),
                'loadingResults' => false,
                'reviews'      => $reviews,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Announcements $record)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProposalsRequest $request)
    {

        $proposal = $this->model::create($request->validated());

        /*  Proceedings::create([
            'path' => $path,
            'proposal_id' => $proposal->id,
            'user_id'  => $request->user_id
        ]); */

        foreach ($request->myFiles as $files) {
            $files->storeAs(Auth::user()->name . 'Expediente'  . $proposal->id, $files->getClientOriginalName(), 'public');
        }

        return redirect()->route("{$this->routeName}index")->with('success', 'Su propuesta ha sido guardada con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */

    public function show(Announcements $proposal)
    {
        if (Proposals::where('announcement_id', '=', $proposal->id)->exists()) {
            return redirect()->route("announcements.index")->with('error', 'Ya te has postulado para esta convocatoria!');
        } else {
            return Inertia::render("Proposals/Create", [
                'titulo'      => 'Propuesta',
                'convocatoria' => $proposal->load(['assesstment_criterias', 'documents_supporting']),
                'state'        => ProposalStates::find(2),
                'routeName'      => $this->routeName,
                'areas'        => Areas_knowledge::all()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */
    public function edit(Proposals $proposal)
    {

        $records = Announcements::find($proposal->announcement_id);
        $records->load(['assesstment_criterias', 'documents_supporting']);
        $criterias = Criterias::where('proposal_id', '=', "$proposal->id")->get();


        return Inertia::render("Proposals/Edit", [
            'titulo'      => 'Editar Propuesta',
            'proposal'    => $proposal,
            'convocatoria' => $records,
            'state'        => ProposalStates::find(2),
            'routeName'      => $this->routeName,
            'criterias' => $criterias->load(['assesstment_criterias', 'users'])
        ]);
    }

    /* 
        Render de review view for the reviewer xd
    */

    public function review(Proposals $proposal)
    {
        $records = Announcements::find($proposal->announcement_id);
        $records->load(['assesstment_criterias', 'documents_supporting']);

        return Inertia::render("Proposals/Review", [
            'titulo'      => 'Revision de propuesta ' . '"' . $proposal->title . '"',
            'proposal'    => $proposal,
            'convocatoria' => $records,
            'routeName'     => $this->routeName,
        ]);
    }

    /*
        Assign the proposal to the reviewers
    */

    public function assignment(Proposals $proposal)
    {
        $records = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'Evaluador');
            }
        )->get();

        return Inertia::render("Assignment/Assign", [
            'titulo'      => 'Asignar evaluadores a la propuesta ' . '"' . $proposal->title . '"',
            'proposal'    => $proposal,
            'records' => $records,
            'routeName'      => $this->routeName,
        ]);
    }


    /* 
        Send the specified Proposal file to the view
    */

    public function downloadPdf($filename, $user, $announcement)
    {
        $pathToFile = storage_path('app/public/' . User::find($user)->name . 'Expediente' . $announcement . '/' . $filename);

        return response()->download($pathToFile);
    }

    /* 
        Give the specified Proposal file path to the view
    */

    public function viewPdf($filename, $user, $announcement)
    {
        $pathToFile = storage_path('app/public/' . User::find($user)->name . 'Expediente' . $announcement . '/' . $filename);

        return response()->make(file_get_contents($pathToFile), 200, [
            'Content-Type'        => mime_content_type($pathToFile),
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    /* 
        Update the specified resource in storage after setting being reviewed.
     */

    public function updateReview(UpdateProposalsRequest $request, Proposals $proposal)
    {
            $proposal->update($request->validated());

            $user = User::find($request->user_id);
            $user->notify(new WorkReviewed($user, $proposal)); 


            return redirect()->route("{$this->routeName}index")->with('success', 'Propuesta revisada correctamente!');
        }

    /* 
        Get proposal reviews State and lenght
    */

    public function getState(Proposals $proposal)
    {
        $reviews = review::where('proposals_id', '=', $proposal->id)->get();
        $reviewrs = proposals_user::where('proposals_id', '=', $proposal->id)->get();

        if ($reviews->count() > floor($reviewrs->count() / 2)) {
            $count = 0;
            foreach ($reviews as $value) {
                if ($value['state_id'] == 4) {
                    $count++;
                }
            }
            if ($count >= floor($reviewrs->count() / 2)) {
                return 4;
            } else {
                return (($reviews->count() - $count) > (floor($reviewrs->count() / 2))) ? 1 : 3;
            }
        }

        return 3;
    }

    /* 
        Sync reviewrs to the proposals
    */

    public function syncReviewrs(Request $request)
    {
        $proposal = Proposals::find($request->proposal);

        $proposal->users()->sync($request->reviewrs);


        foreach ($request->reviewrs as $item) {
            $user = User::find($item);
            $user->notify(new ReviewerAssigned($user, $proposal));
        }

        return redirect()->route("{$this->routeName}index")->with('success', 'Revisores asignados correctamente!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProposalsRequest  $request
     * @param  \App\Models\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProposalsRequest $request, Proposals $proposal)
    {
        $proposal->update($request->validated());
 
        if (!empty($request->myFiles)) {
            foreach ($request->myFiles as $files) {
                $files->storeAs(Auth::user()->name . 'Expediente' . $proposal->id, $files->getClientOriginalName(), 'public');
            }
        }

        review::where('proposals_id', $proposal->id)->delete();

        return redirect()->route("{$this->routeName}index")->with('success', 'Propuesta editada correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proposals $proposal)
    {
        $files = glob('storage' . '/' . Auth::user()->name . 'Expediente' . $proposal->id . '/*');

        proposals_user::where('proposals_id', '=', $proposal->id)->delete();
        review::where('proposals_id', '=', $proposal->id)->delete();


        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        rmdir('storage' . '/' . Auth::user()->name . 'Expediente' . $proposal->id);
        recognitions::where('proposal_id', '=', $proposal->id)->delete();
        $proposal->delete();

        return redirect()->route("{$this->routeName}index")->with('success', 'Propuesta eliminada con éxito');
    }
}
