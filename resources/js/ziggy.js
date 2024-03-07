const Ziggy = {"url":"http:\/\/localhost:8080","port":8080,"defaults":{},"routes":{"login":{"uri":"login","methods":["GET","HEAD"]},"logout":{"uri":"logout","methods":["POST"]},"password.request":{"uri":"forgot-password","methods":["GET","HEAD"]},"password.reset":{"uri":"reset-password\/{token}","methods":["GET","HEAD"],"parameters":["token"]},"password.email":{"uri":"forgot-password","methods":["POST"]},"password.store":{"uri":"reset-password","methods":["POST"]},"register":{"uri":"register","methods":["GET","HEAD"]},"verification.notice":{"uri":"verify-email","methods":["GET","HEAD"]},"verification.verify":{"uri":"verify-email\/{id}\/{hash}","methods":["GET","HEAD"],"parameters":["id","hash"]},"verification.send":{"uri":"email\/verification-notification","methods":["POST"]},"user-profile-information.update":{"uri":"user\/profile-information","methods":["PUT"]},"user-password.update":{"uri":"user\/password","methods":["PUT"]},"password.confirmation":{"uri":"user\/confirmed-password-status","methods":["GET","HEAD"]},"password.confirm":{"uri":"confirm-password","methods":["GET","HEAD"]},"two-factor.login":{"uri":"two-factor-challenge","methods":["GET","HEAD"]},"two-factor.enable":{"uri":"user\/two-factor-authentication","methods":["POST"]},"two-factor.confirm":{"uri":"user\/confirmed-two-factor-authentication","methods":["POST"]},"two-factor.disable":{"uri":"user\/two-factor-authentication","methods":["DELETE"]},"two-factor.qr-code":{"uri":"user\/two-factor-qr-code","methods":["GET","HEAD"]},"two-factor.secret-key":{"uri":"user\/two-factor-secret-key","methods":["GET","HEAD"]},"two-factor.recovery-codes":{"uri":"user\/two-factor-recovery-codes","methods":["GET","HEAD"]},"profile.show":{"uri":"user\/profile","methods":["GET","HEAD"]},"other-browser-sessions.destroy":{"uri":"user\/other-browser-sessions","methods":["DELETE"]},"current-user-photo.destroy":{"uri":"user\/profile-photo","methods":["DELETE"]},"current-user.destroy":{"uri":"user","methods":["DELETE"]},"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"ignition.healthCheck":{"uri":"_ignition\/health-check","methods":["GET","HEAD"]},"ignition.executeSolution":{"uri":"_ignition\/execute-solution","methods":["POST"]},"ignition.updateConfig":{"uri":"_ignition\/update-config","methods":["POST"]},"dashboard":{"uri":"dashboard","methods":["GET","HEAD"]},"users.assign-roles-and-permissions.view":{"uri":"users\/{user}\/assign-roles-and-permissions","methods":["GET","HEAD"],"parameters":["user"],"bindings":{"user":"id"}},"users.assign-roles-and-permissions":{"uri":"users\/{user}\/assign-roles-and-permissions","methods":["POST"],"parameters":["user"],"bindings":{"user":"id"}},"profile.index":{"uri":"profile","methods":["GET","HEAD"]},"profile.create":{"uri":"profile\/create","methods":["GET","HEAD"]},"profile.edit":{"uri":"profile\/{user}\/edit","methods":["GET","HEAD"],"parameters":["user"],"bindings":{"user":"id"}},"profile.update":{"uri":"profile","methods":["PATCH"]},"profile.destroy":{"uri":"profile","methods":["DELETE"]},"profile.assignRole":{"uri":"profile\/{userId}\/assign-role","methods":["POST"],"parameters":["userId"]},"reviews.index":{"uri":"reviews","methods":["GET","HEAD"]},"reviews.create":{"uri":"reviews\/create","methods":["GET","HEAD"]},"reviews.store":{"uri":"reviews","methods":["POST"]},"reviews.show":{"uri":"reviews\/{review}","methods":["GET","HEAD"],"parameters":["review"],"bindings":{"review":"id"}},"reviews.edit":{"uri":"reviews\/{review}\/edit","methods":["GET","HEAD"],"parameters":["review"],"bindings":{"review":"id"}},"reviews.update":{"uri":"reviews\/{review}","methods":["PUT","PATCH"],"parameters":["review"],"bindings":{"review":"id"}},"reviews.destroy":{"uri":"reviews\/{review}","methods":["DELETE"],"parameters":["review"],"bindings":{"review":"id"}},"permissions.index":{"uri":"permissions","methods":["GET","HEAD"]},"permissions.create":{"uri":"permissions\/create","methods":["GET","HEAD"]},"permissions.store":{"uri":"permissions","methods":["POST"]},"permissions.show":{"uri":"permissions\/{permission}","methods":["GET","HEAD"],"parameters":["permission"]},"permissions.edit":{"uri":"permissions\/{permission}\/edit","methods":["GET","HEAD"],"parameters":["permission"],"bindings":{"permission":"id"}},"permissions.update":{"uri":"permissions\/{permission}","methods":["PUT","PATCH"],"parameters":["permission"],"bindings":{"permission":"id"}},"permissions.destroy":{"uri":"permissions\/{permission}","methods":["DELETE"],"parameters":["permission"],"bindings":{"permission":"id"}},"roles.index":{"uri":"roles","methods":["GET","HEAD"]},"roles.create":{"uri":"roles\/create","methods":["GET","HEAD"]},"roles.store":{"uri":"roles","methods":["POST"]},"roles.show":{"uri":"roles\/{role}","methods":["GET","HEAD"],"parameters":["role"]},"roles.edit":{"uri":"roles\/{role}\/edit","methods":["GET","HEAD"],"parameters":["role"],"bindings":{"role":"id"}},"roles.update":{"uri":"roles\/{role}","methods":["PUT","PATCH"],"parameters":["role"],"bindings":{"role":"id"}},"roles.destroy":{"uri":"roles\/{role}","methods":["DELETE"],"parameters":["role"],"bindings":{"role":"id"}},"materia.index":{"uri":"materia","methods":["GET","HEAD"]},"materia.create":{"uri":"materia\/create","methods":["GET","HEAD"]},"materia.store":{"uri":"materia","methods":["POST"]},"materia.show":{"uri":"materia\/{materium}","methods":["GET","HEAD"],"parameters":["materium"]},"materia.edit":{"uri":"materia\/{materium}\/edit","methods":["GET","HEAD"],"parameters":["materium"]},"materia.update":{"uri":"materia\/{materium}","methods":["PUT","PATCH"],"parameters":["materium"]},"materia.destroy":{"uri":"materia\/{materium}","methods":["DELETE"],"parameters":["materium"]},"grupo.index":{"uri":"grupo","methods":["GET","HEAD"]},"grupo.create":{"uri":"grupo\/create","methods":["GET","HEAD"]},"grupo.store":{"uri":"grupo","methods":["POST"]},"grupo.show":{"uri":"grupo\/{grupo}","methods":["GET","HEAD"],"parameters":["grupo"],"bindings":{"grupo":"id"}},"grupo.edit":{"uri":"grupo\/{grupo}\/edit","methods":["GET","HEAD"],"parameters":["grupo"]},"grupo.update":{"uri":"grupo\/{grupo}","methods":["PUT","PATCH"],"parameters":["grupo"]},"grupo.destroy":{"uri":"grupo\/{grupo}","methods":["DELETE"],"parameters":["grupo"]},"usuarios.index":{"uri":"usuarios","methods":["GET","HEAD"]},"usuarios.create":{"uri":"usuarios\/create","methods":["GET","HEAD"]},"usuarios.store":{"uri":"usuarios","methods":["POST"]},"usuarios.show":{"uri":"usuarios\/{usuarios}","methods":["GET","HEAD"],"parameters":["usuarios"]},"usuarios.edit":{"uri":"usuarios\/{usuarios}\/edit","methods":["GET","HEAD"],"parameters":["usuarios"]},"usuarios.update":{"uri":"usuarios\/{usuarios}","methods":["PUT","PATCH"],"parameters":["usuarios"]},"usuarios.destroy":{"uri":"usuarios\/{usuarios}","methods":["DELETE"],"parameters":["usuarios"]},"alumno.index":{"uri":"alumno","methods":["GET","HEAD"]},"alumno.create":{"uri":"alumno\/create","methods":["GET","HEAD"]},"alumno.store":{"uri":"alumno","methods":["POST"]},"alumno.show":{"uri":"alumno\/{alumno}","methods":["GET","HEAD"],"parameters":["alumno"],"bindings":{"alumno":"id"}},"alumno.edit":{"uri":"alumno\/{alumno}\/edit","methods":["GET","HEAD"],"parameters":["alumno"]},"alumno.update":{"uri":"alumno\/{alumno}","methods":["PUT","PATCH"],"parameters":["alumno"]},"alumno.destroy":{"uri":"alumno\/{alumno}","methods":["DELETE"],"parameters":["alumno"]},"profesor.index":{"uri":"profesor","methods":["GET","HEAD"]},"profesor.create":{"uri":"profesor\/create","methods":["GET","HEAD"]},"profesor.store":{"uri":"profesor","methods":["POST"]},"profesor.show":{"uri":"profesor\/{profesor}","methods":["GET","HEAD"],"parameters":["profesor"],"bindings":{"profesor":"id"}},"profesor.edit":{"uri":"profesor\/{profesor}\/edit","methods":["GET","HEAD"],"parameters":["profesor"]},"profesor.update":{"uri":"profesor\/{profesor}","methods":["PUT","PATCH"],"parameters":["profesor"]},"profesor.destroy":{"uri":"profesor\/{profesor}","methods":["DELETE"],"parameters":["profesor"]},"academico.index":{"uri":"academico","methods":["GET","HEAD"]},"academico.create":{"uri":"academico\/create","methods":["GET","HEAD"]},"academico.store":{"uri":"academico","methods":["POST"]},"academico.show":{"uri":"academico\/{academico}","methods":["GET","HEAD"],"parameters":["academico"],"bindings":{"academico":"id"}},"academico.edit":{"uri":"academico\/{academico}\/edit","methods":["GET","HEAD"],"parameters":["academico"]},"academico.update":{"uri":"academico\/{academico}","methods":["PUT","PATCH"],"parameters":["academico"]},"academico.destroy":{"uri":"academico\/{academico}","methods":["DELETE"],"parameters":["academico"]},"habito.index":{"uri":"habito","methods":["GET","HEAD"]},"habito.create":{"uri":"habito\/create","methods":["GET","HEAD"]},"habito.store":{"uri":"habito","methods":["POST"]},"habito.show":{"uri":"habito\/{habito}","methods":["GET","HEAD"],"parameters":["habito"],"bindings":{"habito":"id"}},"habito.edit":{"uri":"habito\/{habito}\/edit","methods":["GET","HEAD"],"parameters":["habito"]},"habito.update":{"uri":"habito\/{habito}","methods":["PUT","PATCH"],"parameters":["habito"]},"habito.destroy":{"uri":"habito\/{habito}","methods":["DELETE"],"parameters":["habito"]},"inteligencia.index":{"uri":"inteligencia","methods":["GET","HEAD"]},"inteligencia.create":{"uri":"inteligencia\/create","methods":["GET","HEAD"]},"inteligencia.store":{"uri":"inteligencia","methods":["POST"]},"inteligencia.show":{"uri":"inteligencia\/{inteligencium}","methods":["GET","HEAD"],"parameters":["inteligencium"]},"inteligencia.edit":{"uri":"inteligencia\/{inteligencium}\/edit","methods":["GET","HEAD"],"parameters":["inteligencium"]},"inteligencia.update":{"uri":"inteligencia\/{inteligencium}","methods":["PUT","PATCH"],"parameters":["inteligencium"]},"inteligencia.destroy":{"uri":"inteligencia\/{inteligencium}","methods":["DELETE"],"parameters":["inteligencium"]},"pregunta.index":{"uri":"pregunta","methods":["GET","HEAD"]},"pregunta.create":{"uri":"pregunta\/create","methods":["GET","HEAD"]},"pregunta.store":{"uri":"pregunta","methods":["POST"]},"pregunta.show":{"uri":"pregunta\/{pregunta}","methods":["GET","HEAD"],"parameters":["pregunta"],"bindings":{"pregunta":"id"}},"pregunta.edit":{"uri":"pregunta\/{pregunta}\/edit","methods":["GET","HEAD"],"parameters":["pregunta"]},"pregunta.update":{"uri":"pregunta\/{pregunta}","methods":["PUT","PATCH"],"parameters":["pregunta"]},"pregunta.destroy":{"uri":"pregunta\/{pregunta}","methods":["DELETE"],"parameters":["pregunta"]},"respuesta.index":{"uri":"respuesta","methods":["GET","HEAD"]},"respuesta.create":{"uri":"respuesta\/create","methods":["GET","HEAD"]},"respuesta.store":{"uri":"respuesta","methods":["POST"]},"respuesta.show":{"uri":"respuesta\/{respuesta}","methods":["GET","HEAD"],"parameters":["respuesta"],"bindings":{"respuesta":"id"}},"respuesta.edit":{"uri":"respuesta\/{respuesta}\/edit","methods":["GET","HEAD"],"parameters":["respuesta"]},"respuesta.update":{"uri":"respuesta\/{respuesta}","methods":["PUT","PATCH"],"parameters":["respuesta"]},"respuesta.destroy":{"uri":"respuesta\/{respuesta}","methods":["DELETE"],"parameters":["respuesta"]},"grupomaterias.index":{"uri":"grupomaterias","methods":["GET","HEAD"]},"grupomaterias.create":{"uri":"grupomaterias\/create","methods":["GET","HEAD"]},"grupomaterias.store":{"uri":"grupomaterias","methods":["POST"]},"grupomaterias.show":{"uri":"grupomaterias\/{grupomaterias}","methods":["GET","HEAD"],"parameters":["grupomaterias"]},"grupomaterias.edit":{"uri":"grupomaterias\/{grupomaterias}\/edit","methods":["GET","HEAD"],"parameters":["grupomaterias"]},"grupomaterias.update":{"uri":"grupomaterias\/{grupomaterias}","methods":["PUT","PATCH"],"parameters":["grupomaterias"]},"grupomaterias.destroy":{"uri":"grupomaterias\/{grupomaterias}","methods":["DELETE"],"parameters":["grupomaterias"]},"recursamiento.index":{"uri":"recursamiento","methods":["GET","HEAD"]},"recursamiento.create":{"uri":"recursamiento\/create","methods":["GET","HEAD"]},"recursamiento.store":{"uri":"recursamiento","methods":["POST"]},"recursamiento.show":{"uri":"recursamiento\/{recursamiento}","methods":["GET","HEAD"],"parameters":["recursamiento"],"bindings":{"recursamiento":"id"}},"recursamiento.edit":{"uri":"recursamiento\/{recursamiento}\/edit","methods":["GET","HEAD"],"parameters":["recursamiento"]},"recursamiento.update":{"uri":"recursamiento\/{recursamiento}","methods":["PUT","PATCH"],"parameters":["recursamiento"]},"recursamiento.destroy":{"uri":"recursamiento\/{recursamiento}","methods":["DELETE"],"parameters":["recursamiento"]},"grupos.assign-group.view":{"uri":"grupos\/{id}\/assign-group","methods":["GET","HEAD"],"parameters":["id"]},"grupo.remove-alumno":{"uri":"grupo\/remove-alumno","methods":["POST"]},"grupos.assign-group.post":{"uri":"gruposAsignacion","methods":["POST"]},"asignar.alumno.recursamiento":{"uri":"asignar-alumno-recursamiento-view\/{id}","methods":["POST"],"parameters":["id"]},"download-AdPdf":{"uri":"download-AdPdf\/{filename}\/{announcement}","methods":["GET","HEAD"],"parameters":["filename","announcement"]},"password.update":{"uri":"password","methods":["PUT"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
