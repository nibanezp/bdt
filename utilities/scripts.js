/**
 * Fichero que contiene el conjunto de funciones JavaScript necesarias
 */

// Función que muestra u oculta la contraseña del usuario
function checker() {
    if (document.getElementById('switch').checked) {
        showPassword();
    }else {
        hidePassword();
    }
}


// Función que cambia el tipo de objeto a "password", ocultando así la contraseña del usuario
function hidePassword() {
    let obj = document.getElementById('password');
    obj.type = "password";
}


// Función que cambia el tipo de objeto a "text", mostrando así la contraseña del usuario
function showPassword() {
    let obj = document.getElementById('password');
    obj.type = "text";
}


// Función que activa el botón de aceptar, para poder registrarse, al aceptar los términos y condiciones de uso.
function checkerAceptar(obj){
    let checked = obj.checked;
    document.getElementById('btnRegister').disabled = !checked;
}


// Función que nos devolverá a la página de la que venimos
function volverAtras(origen){
    window.location= '?action=view&option='+origen;
}


// Función que muestra una alerta pidiendo confirmación al eliminar una oferta
function confirmarEliminarOferta(ofertaId){
    let result = confirm("Seguro que desea eliminar la oferta "+ofertaId);
    if (result){window.location = '?action=ctl&option=eliminarOferta&ofertaId=' + ofertaId;}
}


// Función que muestra una alerta pidiendo confirmación al eliminar un usuario
function confirmarEliminarUsuario(userId){
    let result = confirm("Seguro que desea eliminar el usuario "+userId);
    if (result){window.location = '?action=ctl&option=eliminarUsuario&userId=' + userId;}
}


// Función que recibe una lista de subcategorías y rellena el select correspondiente.
function reloadSubCat(subCatList){
    let selSubCat=document.getElementById("selSubCat");
    let opt = document.createElement('option');
    opt.value = "%";
    selSubCat.innerHTML="Seleccione una opción";
    opt.value = "%";
    opt.innerHTML = "Seleccione una opción";
    selSubCat.appendChild(opt);
    for (let element of subCatList) {
        opt = document.createElement('option');
        opt.value = element.id;
        opt.innerHTML = element.nombre;
       selSubCat.appendChild(opt);
    }
    $('#selSubCat').val('%').trigger('change');
}


// Función que recibe una lista de ofertas, y con ella crea y rellena una tabla, además, tendrá en cuenta el rol
// del usuario conectado, dependiendo del rol mostrara las ofertas propias del administrador (rol == 1),
// o las ofertas propias del usuario (rol != 1).
// La función también busca el origen del que procedemos para saber si tenemos que mostrar opciones de eliminar y
// modificar ofertas o no.
function populateTable(ofertas, role){
    // Aunque desconecto las señales de los selectores de filtrado, por mayor seguridad,
    // he decido crear el elemento "origen", el cual me indicará de donde venimos
    // de este modo, sé si tengo que cargar tabla o no y qué tabla cargar.

    // Destruimos la tabla antigua, para dejarla limpia, con esto evitamos conflictos con los filtros de categoría
    // y subcategoría.
    $('#tblListado').dataTable().fnDestroy();

    let origen = document.getElementById("origen").value;
    if (origen === "listado" || origen === 'misOfertas') {
        let tbody = document.getElementById("tbody");
        tbody.innerHTML = '';
        for (let element of ofertas) {
            let fila = '<tr>' +
                '<td class="text-center">' + element.id + '</td>' +
                '<td>' + element.catNombre + '</td>' +
                '<td>' + element.subCatNombre + '</td>' +
                '<td>' + element.descripcion + '</td>' +
                '<td class="text-center">' + element.valoracion + '</td>' +
                '<td class="text-center">' + element.votos + '</td>';
            // Esta columna solo la queremos en el listado general, ya que no tiene sentido que esté en el listado de
            // misOfertas, pues un usuario no va a querer contactar consigo mismo.
            if (origen === 'listado') {
                fila += '<td class="text-center">' +
                    '<a href="?action=view&option=ofertante&userId=' + element.userId + '&ofertaId=' + element.id + '">' + element.username +
                    '</a>' +
                    '</td >';
            }
            // Estas dos columnas solo se pondrán en el listado general cuando el rol del usuario sea administrador
            // o bien cuando cualquier usuario esté mirando sus propias ofertas.
            if (role == 1 || origen === 'misOfertas') {
                fila += '<td class="text-center">' +
                    '<a href="javascript:confirmarEliminarOferta(' + element.id + ')">' +
                    '<img src="view/imagenes/Recycle-Bin.png" height="20" width="20" title="Borrar">' +
                    '</a>' +
                    '</td>' +
                    '<td class="text-center">' +
                    '<a href="?action=view&option=modificarOferta&ofertaId=' + element.id + '">' +
                            '<img src="view/imagenes/modificar.png" height="20" width="20" title="Modificar">' +
                    '</a>' +
                '</td>'
            }
            fila += '</tr>';
            tbody.innerHTML += fila;
        }
        populateDataTable('#tblListado');
    }
}


// Función que recibe una lista de usuarios y con ella crea y rellena una tabla.
function populateUsuarios(usuarios){
    let tbody = document.getElementById("tbody");
    tbody.innerHTML = '';
    for (let element of usuarios) {
        let fila = '<tr>' +
            '<td>' + element.id + '</td>' +
            '<td>' + element.username + '</td>' +
            '<td>' + element.passw + '</td>' +
            '<td>' + element.email + '</td>' +
            '<td>' + element.nombre + '</td>' +
            '<td>' + element.apellidos + '</td>' +
            '<td>' + element.poblacion + '</td>' +
            '<td>' + element.horas + '</td>' +
            '<td>' + element.roleId + '</td>' +
            '<td>' + element.roleName + '</td>' +
            '<td>' + element.valoracion + '</td>' +
            '<td>' + element.votos + '</td>' +
            '<td class="text-center">'+
                '<a href="javascript:confirmarEliminarUsuario('+element.id+')">'+
                    '<img src="view/imagenes/Recycle-Bin.png" height="20" width="20" title="Borrar">'+
                '</a>'+
            '</td >'+
            '<td class="text-center">'+
                '<a href="?action=view&option=personalInfo&userId='+element.id+'">'+
                    '<img src="view/imagenes/modificar.png" height="20" width="20" title="Modificar">'+
                '</a>'+
            '</td>'
        fila += '</tr>';
        tbody.innerHTML += fila;
    }
    populateDataTable('#tblListadoUsers');
}


// Función que recibe el nombre de una table y genera un DataTable
function populateDataTable(tableName, pageLength= 5){
    $(tableName).DataTable({
        order: [[0, 'asc'], [1, 'asc'], [2, 'asc']], // Columnas por las que queremos ordenar
        ordering: true,  // Permite que las columnas sean ordenadas haciendo clic en la cabecera
        paging: true, // Muestra(true) u oculta(false) el select con las cantidades
        lengthMenu: [5, 10, 15, 20, 50, 100], // Menu desplegable "Show entries"
        pageLength: pageLength, // Valor inicial del menu desplegable "Show entries"
        scrollCollapse: true,
        oLanguage: {"sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros"},//Texto a mostrar en la sección info
        info: true, // Muestra(true) u oculta(false) la sección info: "Showing 1 to 10 of 16 entries
        scrollY: '400px', // Altura de la tabla a partir de la cual queremos que nos muestre el scroll vertical
        scrollX: true, // Anchura de la tabla a partir de la cual queremos que nos muestre el scroll horizontal
        pagingType: 'full_numbers',
        language: {
            lengthMenu: 'Mostrar _MENU_ registros por pagina',
            zeroRecords: 'Nothing found - sorry',
            infoEmpty: 'No records available',
        },

    });

}


// Se muestra la parte del top menu que nos interesa en función del rol de usuario cuando está conectado
function topMenuLogged(role){
    let visibility = "hidden";
    let disable = true;
    if(role===1){
        visibility = "visible";
        disable = false;
    }
    document.getElementById("adminOpts").style.visibility = visibility;
    document.getElementById("adminOpts").disabled = disable;
    document.getElementById("listado").style.visibility = "visible";
    document.getElementById("listado").disabled = false;
    document.getElementById("misOfertas").style.visibility = "visible";
    document.getElementById("misOfertas").disabled = false;
    document.getElementById("personalInfo").style.visibility = "visible";
    document.getElementById("personalInfo").disabled = false;
    document.getElementById("btnLogin").style.visibility = "hidden";
    document.getElementById("btnLogin").disabled = true;
    document.getElementById("btnLogout").style.visibility = "visible";
    document.getElementById("btnLogout").disabled = false;
    document.getElementById("btnSignUp").style.visibility = "hidden";
    document.getElementById("btnSignUp").disabled = true;
}


// Se muestra la parte del top menu que nos interesa en función del rol de usuario cuando está desconectado
function topMenuLogout(){
    document.getElementById("adminOpts").style.visibility = "hidden";
    document.getElementById("adminOpts").disabled = true;
    document.getElementById("listado").style.visibility = "hidden";
    document.getElementById("listado").disabled = true;
    document.getElementById("misOfertas").style.visibility = "hidden";
    document.getElementById("misOfertas").disabled = true;
    document.getElementById("personalInfo").style.visibility = "hidden";
    document.getElementById("personalInfo").disabled = true;
    document.getElementById("btnLogin").style.visibility = "visible";
    document.getElementById("btnLogin").disabled = false;
    document.getElementById("btnLogout").style.visibility = "hidden";
    document.getElementById("btnLogout").disabled = true;
    document.getElementById("btnSignUp").style.visibility = "visible";
    document.getElementById("btnSignUp").disabled = false;
}
