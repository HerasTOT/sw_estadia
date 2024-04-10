import {
  mdiMenu,
  mdiClockOutline,
  mdiCloud,
  mdiCrop,
  mdiAccount,
  mdiCogOutline,
  mdiEmail,
  mdiLogout,
  mdiThemeLightDark,
  mdiGithub,
  mdiReact,
} from "@mdi/js";

import { usePage } from "@inertiajs/vue3";


export default [

  {
    isCurrentUser: true,
    menu: [
      {
        href:"/perfil",
        icon: mdiAccount,
        label: "Mi perfil",
        to: "/profile",
      },
      {
        isDivider: true,
      },
      {
        icon: mdiLogout,
        label: "Cerrar Sesion",
        isLogout: true,
      },
    ],
  },
  {
    icon: mdiAccount,
    isRol: true,
  },
  {
    icon: mdiLogout,
    label: "Log out",
    isDesktopNoLabel: true,
    isLogout: true,
  },
];
