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
  mdiLogin,
  mdiAccountTag
} from "@mdi/js";

export default [
  {
    icon: mdiMenu,
    label: "Información",
    menu: [
      {
        icon: mdiClockOutline,
        label: "Calendario",
      },
      {
        icon: mdiCloud,
        label: "Cloud",
      },
      {
        isDivider: true,
      },
      {
        icon: mdiGithub,
        label: "Github",
      },
    ],
  },
  {
    icon: mdiThemeLightDark,
    label: "Light/Dark",
    isDesktopNoLabel: true,
    isToggleLightDark: true,
  },
  {
    icon: mdiLogin,
    label: "Iniciar Sesion",
    isDesktopNoLabel: false,
    isLogin: true,
  },
  {
    icon: mdiAccountTag,
    label: "Registrarse",
    isDesktopNoLabel: false,
    isRegister: true,
  },
];
