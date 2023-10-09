<?php

namespace App\Http\Controllers;

use App\Models\Announcements;
use App\Http\Requests\StoreAnnouncementsRequest;
use App\Http\Requests\UpdateAnnouncementsRequest;
use App\Models\announcement_assestment_criteria;
use App\Models\announcements_document_supporting;
use App\Models\Assestment_Criteria;
use App\Models\calendar_announcement;
use App\Models\Document_Supporting;
use App\Models\Events;
use App\Models\Institutions;
use App\Models\Proposals;
use App\Models\User;
use Database\Seeders\AssestmentCriteriaSeeder;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Validator;



class AnnouncementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private string $routeName;
    private Announcements $model;
    private string $module = 'announcements';

    public function __construct()
    {
        /* $this->middleware('auth');
 */
        $this->model = new Announcements();
        $this->routeName = 'announcements.';

        /*    $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['update', 'edit']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy', 'edit']); */
    }

    public function index(Request $request): Response
    {
        $records = new Announcements();
        $records = $records->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
            }
        })->get();

        return Inertia::render("Anouncement/Index", [
            'titulo'      => 'Convocatorias',
            'records'    => $records->load('assesstment_criterias', 'documents_supporting', 'calendars'),
            'routeName'      => $this->routeName,
            'loadingResults' => false,
            'events' => Events::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Anouncement/Create", [
            'titulo'      => 'Crear una convocatoria',
            'routeName'      => $this->routeName,
            'institutions' => Institutions::all(),
            'assesstments' =>   Assestment_Criteria::all(),
            'documents'    => Document_Supporting::all(),
            'events' => Events::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAnnouncementsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnnouncementsRequest $request)
    {
        if (empty($request->assesstments)) {
            return redirect()->back()->withErrors(['Seleccione al menos un criterio para la convocatoria!']);
        } else if (empty($request->documents)) {
            return redirect()->back()->withErrors(['Seleccione al menos un documento para la convocatoria!']);
        } else {
            $record = $this->model::create($request->validated());
            $criteria = new Assestment_Criteria();
            $docuemnt = new Document_Supporting();

            foreach ($request->dates as $value) {
                calendar_announcement::create(
                    [
                        'name' => $value['name'],
                        'date_start' => $value['date_start'],
                        'date_end' => $value['date_end'],
                        'announcements_id' => $record->id,
                    ]
                );
            }

            foreach ($request->documents as $value) {
                if (isset($value['id'])) {
                    $record->documents_supporting()->attach($value['id']);
                } else {
                    $docuemnt = Document_Supporting::create(
                        [
                            'name' => $value['name'],
                        ]
                    );
                    $record->documents_supporting()->attach($docuemnt->id);
                }
            }


            foreach ($request->assesstments as $value) {
                if (isset($value['id'])) {
                    $record->assesstment_criterias()->attach($value['id']);
                } else {
                    $criteria = Assestment_Criteria::create(
                        [
                            'name' => $value['name'],
                            'value' => $value['value'],
                        ]
                    );
                    $record->assesstment_criterias()->attach($criteria->id);
                }
            }

            foreach ($request->myFiles as $files) {
                $files->storeAs($request->name . 'advertising', $files->getClientOriginalName(), 'public');
            }
        }

        return redirect()->route("{$this->routeName}index")->with('success', 'Convocatoria guardada con éxito!');
    }

    /* 
        Send the specified Proposal file to the view
    */

    public function downloadPdf($filename, $announcement)
    {
        $pathToFile = storage_path('app/public/' . $announcement . 'advertising' . '/' . $filename);

        return response()->download($pathToFile);
    }

    /* 
        Give the specified Proposal file path to the view
    */

    public function viewPdf($filename, $announcement)
    {
        $pathToFile =  storage_path('app/public/' . $announcement . 'advertising' . '/' . $filename);

        return response()->make(file_get_contents($pathToFile), 200, [
            'Content-Type'        => mime_content_type($pathToFile),
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcements  $announcements
     * @return \Illuminate\Http\Response
     */
    public function show(Announcements $announcements)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcements  $announcements
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcements $announcement)
    {
        return Inertia::render("Anouncement/Edit", [
            'titulo'      => 'Editar una convocatoria',
            'routeName'      => $this->routeName,
            'institutions' => Institutions::all(),
            'assesstments' =>   Assestment_Criteria::all(),
            'documents'    => Document_Supporting::all(),
            'events' => Events::all(),
            'announcement' => $announcement->load('assesstment_criterias', 'documents_supporting', 'calendars')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnnouncementsRequest  $request
     * @param  \App\Models\Announcements  $announcements
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnnouncementsRequest $request, Announcements $announcement)
    {
        if (empty($request->assesstments)) {
            return redirect()->back()->withErrors(['Seleccione al menos un criterio para la convocatoria!']);
        } else if (empty($request->documents)) {
            return redirect()->back()->withErrors(['Seleccione al menos un documento para la convocatoria!']);
        } else {
            $announcement->update($request->validated());
            $criteria = new Assestment_Criteria();
            $docuemnt = new Document_Supporting();

            calendar_announcement::where('announcements_id', '=', $announcement->id)->delete();
            announcement_assestment_criteria::where('announcements_id', '=', $announcement->id)->delete();
            announcements_document_supporting::where('announcements_id', '=', $announcement->id)->delete();

            foreach ($request->dates as $value) {
                calendar_announcement::create(
                    [
                        'name' => $value['name'],
                        'date_start' => $value['date_start'],
                        'date_end' => $value['date_end'],
                        'announcements_id' => $announcement->id,
                    ]
                );
            }

            foreach ($request->documents as $value) {
                if (isset($value['id'])) {
                    $announcement->documents_supporting()->attach($value['id']);
                } else {
                    $docuemnt = Document_Supporting::create(
                        [
                            'name' => $value['name'],
                        ]
                    );
                    $announcement->documents_supporting()->attach($docuemnt->id);
                }
            }


            foreach ($request->assesstments as $value) {
                if (isset($value['id'])) {
                    $announcement->assesstment_criterias()->attach($value['id']);
                } else {
                    $criteria = Assestment_Criteria::create(
                        [
                            'name' => $value['name'],
                            'value' => $value['value'],
                        ]
                    );
                    $announcement->assesstment_criterias()->attach($criteria->id);
                }
            }

            if (isset($request->myFiles)) {
                foreach ($request->myFiles as $files) {
                    $files->storeAs($request->name . 'advertising', $files->getClientOriginalName(), 'public');
                }
            }
        }

        return redirect()->route("{$this->routeName}index")->with('success', 'Convocatoria guardada con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcements  $announcements
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcements $announcement)
    {
        $files = glob('storage' . '/' . $announcement . 'advertising' . '/*');

        calendar_announcement::where('announcements_id', '=', $announcement->id)->delete();
        announcement_assestment_criteria::where('announcements_id', '=', $announcement->id)->delete();
        announcements_document_supporting::where('announcements_id', '=', $announcement->id)->delete();

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        rmdir('storage' . '/' . $announcement . 'advertising' . '/*');
        $announcement->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Convocatoria eliminada con éxito');
    }
}
