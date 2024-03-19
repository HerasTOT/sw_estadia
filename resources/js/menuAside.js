import {
  mdiAccountCircle,
  mdiMonitor,
  mdiGithub,
  mdiLock,
  mdiAlertCircle,
  mdiSquareEditOutline,
  mdiTable,
  mdiViewListOutline,
  mdiTelevisionGuide,
  mdiResponsive,
  mdiSecurity,
  mdiClockCheck,
  mdiBookshelf,
  mdiCalendarAccountOutline,
  mdiClockTimeEleven,
  mdiAccount,
  mdiBedClock,
  mdiEmoticonHappyOutline ,
  mdiFileDocumentEditOutline 

} from "@mdi/js";



export default [
  {
    href: "/dashboard",
    to: "/dashboard",
    icon: mdiMonitor,
    label: "Dashboard",
    role: "Admin"
  },

  
  {
    label: "Catalogo",
    icon: mdiViewListOutline,
    role: "Admin",
    menu: [
 
      {
        label: "Materias",
        href: "/materia",
        to: "/materia",
        permission: 'materia.index',
        icon: mdiBookshelf,
      },
      {
        label: "Periodo",
        href: "/periodo",
        icon: mdiBookshelf,
       
      },
    ],
  },


  {
    href:"/grupo",
    label: "Grupos",
    icon: mdiBookshelf,
    role: "Admin",
  }, 
  
  {
    href:"/usuarios",
    label: "Usuario",
    icon: mdiBookshelf,
    role: "Admin",
  }, 

  {
    href:"/recursamiento",
    label: "Recursamiento",
    icon: mdiBookshelf,
    role: "Admin",
  }, 
  {
    href:"/lista",
    label: "Recursamientos disponibles",
    icon: mdiBookshelf,
    role: "Alumno",
  }, 
  {
    label: "Formatos",
    icon: mdiFileDocumentEditOutline ,
    role: "Alumno",
    menu: [
      {
        href:"/academico",
        label: "Academico",
        icon: mdiBookshelf,
        role: "Alumno",
      }, 
      {
        href:"/habito",
        label: "Habitos",
        icon: mdiBedClock,
        role: "Alumno",
      }, 
      {
        href:"/inteligencia",
        label: "Inteligencia",
        icon: mdiEmoticonHappyOutline ,
        role: "Alumno",
      }, 
      {
        href:"/encuesta",
        label: "Encuesta recursamientos",
        icon: mdiBookshelf,
        role: "Alumno",
      }, 
    ]
  },
  {
    label: "Formularios",
    icon: mdiFileDocumentEditOutline ,
    role: "Admin",
    menu: [
      {
        href:"/pregunta",
        label: "Gestion de Formularios",
        icon: mdiBookshelf,
        role: "Admin",
      }, 
      {
        href:route('pregunta.habilitar'),
        label: "Activar Formularios",
        icon: mdiBookshelf,
        role: "Admin",
      }, 
     
    ]
  },
  {
    label: "Formatos",
    icon: mdiFileDocumentEditOutline ,
    role: "Admin",
    menu: [
      {
        href:"/academico",
        label: "Academico",
        icon: mdiBookshelf,
        role: "Admin",
      }, 
      {
        href:"/habito",
        label: "Habitos",
        icon: mdiBedClock,
        role: "Admin",
      }, 
      {
        href:"/encuesta",
        label: "Encuesta recursamientos",
        icon: mdiBookshelf,
        role: "Admin",
      }, 
      {
        href:"/inteligencia",
        label: "Inteligencia",
        icon: mdiEmoticonHappyOutline ,
        role: "Admin",
      }, 
    ]
  }


];
