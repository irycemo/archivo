<x-app-layout>

    <div class="relative min-h-screen md:flex">

        {{-- Sidebar --}}
        <div id="sidebar" class="z-50 bg-white w-64 absolute inset-y-0 left-0 transform -translate-x-full transition duration-200 ease-in-out md:relative md:translate-x-0">

            {{-- Header --}}
            <div class="w-100 flex-none bg-white border-b-2 border-b-grey-200 flex flex-row p-5 pr-0 justify-between items-center h-20 ">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="mx-auto">

                    <img class="h-16" src="{{ asset('storage/img/logo2.png') }}" alt="Logo">

                </a>

                {{-- Side Menu hide button --}}
                <button  type="button" title="Cerrar Menú" id="sidebar-menu-button" class="md:hidden mr-2 inline-flex items-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">

                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </button>

            </div>

            {{-- Nav --}}
            <nav class="p-4 text-rojo">

                @can('Lista de usuarios')

                    <a href="#usuarios" class="mb-3 capitalize font-medium text-md transition ease-in-out duration-500 flex hover  hover:bg-gray-100 p-2 px-4 rounded-xl">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-4 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>

                        Usuarios
                    </a>

                @endcan

                @can('Lista de archivos catastro')

                    <a href="#archivoCatastro" class="mb-3 capitalize font-medium text-md hover:text-red-600 transition ease-in-out duration-500 flex hover  hover:bg-gray-100 p-2 px-4 rounded-xl">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-4 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>

                        Archivo
                    </a>

                @endcan

                @can('Lista de archivos rpp')

                    <a href="#archivoRpp" class="mb-3 capitalize font-medium text-md hover:text-red-600 transition ease-in-out duration-500 flex hover  hover:bg-gray-100 p-2 px-4 rounded-xl">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-4 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>

                        Archivo
                    </a>

                @endcan

                @can('Lista de solicitudes rpp')

                    <a href="#solicitudesRpp" class="mb-3 capitalize font-medium text-md hover:text-red-600 transition ease-in-out duration-500 flex hover  hover:bg-gray-100 p-2 px-4 rounded-xl">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>

                        Solicitudes
                    </a>

                @endcan

                @can('Lista de solicitudes catastro')

                    <a href="#solicitudesCatastro" class="mb-3 capitalize font-medium text-md hover:text-red-600 transition ease-in-out duration-500 flex hover  hover:bg-gray-100 p-2 px-4 rounded-xl">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>

                        Solicitudes
                    </a>

                @endcan

                @can('Distribución RPP')

                    <a href="#distribuidor" class="mb-3 capitalize font-medium text-md hover:text-red-600 transition ease-in-out duration-500 flex hover  hover:bg-gray-100 p-2 px-4 rounded-xl">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-4 " fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                        </svg>

                        Distribución
                    </a>

                @endcan

                @can('Distribución Catastro')

                    <a href="#distribuidor" class="mb-3 capitalize font-medium text-md hover:text-red-600 transition ease-in-out duration-500 flex hover  hover:bg-gray-100 p-2 px-4 rounded-xl">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-4 " fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                        </svg>

                        Distribución
                    </a>

                @endcan

            </nav>

        </div>

        {{-- Content --}}
        <div class="flex-1 flex-col flex max-h-screen overflow-x-auto min-h-screen">

            {{-- Mobile --}}
            <div class="w-100 bg-white border-b-2 border-b-grey-200 flex-none flex flex-row p-5 justify-between items-center h-20">

                <!-- Mobile menu button-->
                <div class="flex items-center">

                    <button  type="button" title="Abrir Menú" id="mobile-menu-button" class="md:hidden inline-flex items-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">

                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>

                    </button>

                </div>

                {{-- Logo --}}
                <p class="font-semibold text-2xl text-rojo">Manual de Usuario</p>

                <div></div>

            </div>

            {{-- Main Content --}}
            <div class="bg-white flex-1 overflow-y-auto py-8 md:border-l-2 border-l-grey-200">

                <div class="lg:w-2/3 mx-auto rounded-xl">

                    <div class="capitulo mb-10" id="introduccion">

                        <h2 class="text-2xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-6  bg-white">Introducción</h2>

                        <div class="  px-3">

                            <p class="mb-2">
                                El Sistema de Archivo, tiene como propósito administrar el archivo del Instituto Registral y Catastral de Michoacán.
                                El sistema permite dar seguimiento a las incidencias que cada archivo fisico, lleva el control de las solicitudes de los mismos, las incidencias y las digitalicaciones
                                . La información puede ser accesada y procesada en cada una de las áreas correspondientes.
                            </p>

                        </div>

                    </div>

                    <div class="capitulo mb-10" id="usuarios">

                        <h2 class="text-2xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-6  bg-white">Usuarios</h2>

                        <div class="  px-3">

                            <p class="mb-2">
                                La sección de usuarios lleva el control del registro de los usuarios del sistema. Los usuarios estan clasificados por roles
                                ('Jefe de Departamento' y 'Distribuidor' y 'Surtidor', 'Solicitante', 'Digitalizador')
                                cada uno con atribuciones distintas. Solo los usuarios con rol de "Jefe de Departamento" pueden agregar nuevos usuarios y editarlos.
                            </p>

                            <p>
                                <strong>Busqueda de usuario:</strong>
                                puede hacer busqueda de usuarios por cualquiera de las columnas que muestra la tabla.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/usuarios_buscar.jpg') }}" alt="Imágen buscar">

                            <p>
                                <strong>Agregar nuevo usuario:</strong>
                                puede agregar un nuevo usuario haciendo click el el botón "Agregar nuevo usuario" esta acción deplegará una ventana modal
                                en la cual se ingresará la información necesaria para el registro. Al hacer click en el botón "Guardar" se generará el registro con los datos
                                proporcionados. Al hacer click en cerrar se cerrará la ventana modal borrando la información proporcionada.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/usuarios_modal_crear.jpg') }}" alt="Imágen crear">

                            <p>
                                <strong>Editar usuario:</strong>
                                cada usuario tiene asociado dos botones de acciones, puede editar un usuario haciendo click el el botón "Editar" esta acción deplegará una ventana modal
                                en la cual se mostrará la información del usuario para actualizar.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/usuarios_editar.jpg') }}" alt="Imágen buscar">

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/usuarios_modal_editar.jpg') }}" alt="Imágen editar">

                            <p>
                                <strong>Borrar usuario:</strong>
                                puede borrar un usuario haciendo click el el botón "Borrar" esta acción deplegará una ventana modal
                                en la cual se mostrará una advertencia, dando la opcion de cancelar o borrar la información.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/usuarios_borrar.jpg') }}" alt="Imágen borrar">

                            <p>
                                Al crear un usuario, su credenciales para iniciar sesión seran su correo y la contraseña "sistema", al tratar de iniciar sesión le pedira actualizar su contraseña.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/actualizar_contraseña.jpg') }}" alt="Imágen contraseña">

                            <p>
                                Puede revisar su perfil de usuario haciendo click en el circulo superior izquierdo en la opción "Mi perfil"
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/perfil.jpg') }}" alt="Imágen perfil">

                        </div>

                    </div>

                    <div class="capitulo mb-10" id="archivoCatastro">

                        <h2 class="text-2xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-6  bg-white">Archivo</h2>

                        <div class="  px-3">

                            <p class="mb-2">
                                La sección de archivo lleva el control del registro de los archivos los cuales estarán ligados a incidencias y solicitudes. Cada registro tiene
                                los siguientes campos:
                            </p>

                            <p class="mb-2 px-4">
                                <strong>Tomo:</strong> Es el tomo al que pertenece del archivo, puede tenerlo  o no.
                                <br>
                                <strong>Folio:</strong> El número de hojas que contiene el archivo.
                                <br>
                                <strong>Tarjeta:</strong> Campo para indicar si el archivo tiene tarjeta.
                                <br>
                                <strong>Localidad:</strong> Localidad (Cuenta predial).
                                <br>
                                <strong>Oficina:</strong> Oficina (Cuenta predial).
                                <br>
                                <strong>Tipo:</strong> Tipo (Cuenta predial).
                                <br>
                                <strong>Registro:</strong> Registro (Cuenta predial).
                                <br>
                                <strong>Archivo digitalizado:</strong> Si se ha digitalizado el archivo puede incluirlo en este campo los archivos deben ser formato PDF.
                                <br>
                            </p>

                            <p>
                                <strong>Busqueda de archivo:</strong>
                                puede hacer busqueda de archivos por cualquiera de las columnas que muestra la tabla.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/archivos_buscar.jpg') }}" alt="Imágen buscar">

                            <p>
                                <strong>Agregar nuevo archivo:</strong>
                                puede agregar una nuevo archivo haciendo click el el botón "Agregar nuevo archivo" esta acción deplegará una ventana modal
                                en la cual se ingresará la información necesaria para el registro. Al hacer click en el botón "Guardar" se generará el registro con los datos
                                proporcionados. Al hacer click en cerrar se cerrará la ventana modal borrando la información proporcionada.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/archivos_modal_crear.jpg') }}" alt="Imágen modal crear">

                            <p>
                                <strong>Editar archivo:</strong>
                                cada archivo tiene asociado tres botones de acciones, puede editar un archivo haciendo click el el botón "Editar" esta acción deplegará una ventana modal
                                en la cual se mostrará la información de la dependencia para actualizar.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/archivos_editar.jpg') }}" alt="Imágen editar">

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/archivos_modal_editar.jpg') }}" alt="Imágen editar modal">

                            <p>
                                <strong>Borrar archivo:</strong>
                                puede borrar un archivo haciendo click el el botón "Borrar" esta acción deplegará una ventana modal
                                en la cual se mostrará una advertencia, dando la opcion de cancelar o borrar la información.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/archivos_borrar.jpg') }}" alt="Imágen borrar">

                            <p>
                                <strong>Incidencias:</strong>
                                puede asociar incidencias a cada archivo haciendo click en el botón "Incidencias" esta acción desplegará una ventana modal
                                en la que podra ver el listado de incidencias asociadas al archivo como ingresar una nueva.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/archivos_incidencias.jpg') }}" alt="Imágen borrar">

                        </div>

                    </div>

                    <div class="capitulo mb-10" id="archivoRpp">

                        <h2 class="text-2xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-6  bg-white">Archivo</h2>

                        <div class="  px-3">

                            <p class="mb-2">
                                La sección de archivo lleva el control del registro de los archivos los cuales estaran ligados a incidencias y solicitudes. Cada registro tiene
                                los siguientes campos:
                            </p>

                            <p class="mb-2 px-4">
                                <strong>Tomo:</strong> Es el tomo al que pertenece del archivo.
                                <br>
                                <strong>Tomo Bis:</strong> Identificador para tomos repetidos.
                                <br>
                                <strong>Sección:</strong> Sección a la que pertenece.
                                <br>
                                <strong>Distrito:</strong> Distrito al que pertenece.
                                <br>
                                <strong>Archivo digitalizado:</strong> Si se ha digitalizado el archivo puede incluirlo en este campo los archivos deben ser formato PDF.
                                <br>
                            </p>

                            <p>
                                <strong>Busqueda de archivo:</strong>
                                puede hacer busqueda de archivos por cualquiera de las columnas que muestra la tabla.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/archivos_buscar_rpp.jpg') }}" alt="Imágen buscar">

                            <p>
                                <strong>Agregar nuevo archivo:</strong>
                                puede agregar una nuevo archivo haciendo click el el botón "Agregar nuevo archivo" esta acción deplegará una ventana modal
                                en la cual se ingresará la información necesaria para el registro. Al hacer click en el botón "Guardar" se generará el registro con los datos
                                proporcionados. Al hacer click en cerrar se cerrará la ventana modal borrando la información proporcionada.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/archivos_modal_crear_rpp.jpg') }}" alt="Imágen modal crear">

                            <p>
                                <strong>Editar archivo:</strong>
                                cada archivo tiene asociado dos botones de acciones, puede editar un archivo haciendo click el el botón "Editar" esta acción deplegará una ventana modal
                                en la cual se mostrará la información de la dependencia para actualizar.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/archivos_editar_rpp.jpg') }}" alt="Imágen editar">

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/archivos_modal_editar_rpp.jpg') }}" alt="Imágen editar modal">

                            <p>
                                <strong>Borrar archivo:</strong>
                                puede borrar un archivo haciendo click el el botón "Borrar" esta acción deplegará una ventana modal
                                en la cual se mostrará una advertencia, dando la opcion de cancelar o borrar la información.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/archivos_borrar_rpp.jpg') }}" alt="Imágen borrar">

                            <p>
                                <strong>Incidencias:</strong>
                                puede asociar incidencias a cada archivo haciendo click en el botón "Incidencias" esta acción desplegará una ventana modal
                                en la que podra ver el listado de incidencias asociadas al archivo como ingresar una nueva.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/archivos_incidencias.jpg') }}" alt="Imágen borrar">

                        </div>

                    </div>

                    <div class="capitulo mb-10" id="solicitudesRpp">

                        <h2 class="text-2xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-6  bg-white">Solicitudes</h2>

                        <div class="  px-3">

                            <p class="mb-2">
                                La sección de solicitudes lleva el control del registro de las solicitudes.
                            </p>

                            <p>
                                <strong>Busqueda de solicitud:</strong>
                                puede hacer busqueda de solicitudes por cualquiera de las columnas que muestra la tabla.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_buscar_rpp.jpg') }}" alt="Imágen buscar">

                            <p>
                                <strong>Agregar nuevo solicitud:</strong>
                                puede agregar una nueva solicitud haciendo click el el botón "Agregar nueva solicitud" esta acción deplegará una ventana modal
                                en la cual se ingresará la información necesaria para el registro. Al hacer click en el botón "Guardar" se generará el registro con los datos
                                proporcionados. Al hacer click en cerrar se cerrará la ventana modal borrando la información proporcionada.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_modal_crear_rpp.jpg') }}" alt="Imágen modal crear">

                            <p>
                                Puede hacer busquedas de los archivos a solicitar por los siguientes criterios: Tomo, Sección, Distrito, Bis. Si el archivo se encuentra disponible
                                para ser solicitado aparecerá en el área de Resultado de busqueda.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_modal_crear_rpp_2.jpg') }}" alt="Imágen modal crear">

                            <p>
                                Para poder solicitar el archivo es necesario que se indique a que empleado se le asginara la entrega del archivo. La lista de empleados
                                que muestra esta sujeta a dos criterios: El primero, el empleado debe de estar presente, es decir debe de haber checado en el sistema de personal.
                                El segundo, la lista mostrará solo aquellos empleados que pertenecen al área del solicitador.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_modal_crear_rpp_3.jpg') }}" alt="Imágen modal crear">

                            <p>
                                Una vez hecho la asignación pude eliminarla haciendo click en el botón "Eliminar".
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_modal_crear_rpp_4.jpg') }}" alt="Imágen modal crear">

                            <p>
                                <strong>Editar solicitud:</strong>
                                cada solicitud tiene asociado tres botones de acciones, puede editar una solicitud haciendo click el el botón "Editar" esta acción deplegará una ventana modal
                                en la cual se mostrará la información de la solicitud para actualizar.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_editar_rpp.jpg') }}" alt="Imágen editar">

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_modal_editar_rpp.jpg') }}" alt="Imágen editar modal">

                            <p>
                                <strong>Borrar solicitud:</strong>
                                puede borrar una solicitud haciendo click el el botón "Borrar" esta acción deplegará una ventana modal
                                en la cual se mostrará una advertencia, dando la opcion de cancelar o borrar la información.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_borrar_rpp.jpg') }}" alt="Imágen borrar">

                            <p>
                                Puede ver la información general de la solicitud haciendo click en el botón "Ver"
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_ver_catastro.jpg') }}" alt="Imágen borrar">

                        </div>

                    </div>

                    <div class="capitulo mb-10" id="solicitudesCatastro">

                        <h2 class="text-2xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-6  bg-white">Solicitudes</h2>

                        <div class="  px-3">

                            <p class="mb-2">
                                La sección de solicitudes lleva el control del registro de las solicitudes.
                            </p>

                            <p>
                                <strong>Busqueda de solicitud:</strong>
                                puede hacer busqueda de solicitudes por cualquiera de las columnas que muestra la tabla.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_buscar_rpp.jpg') }}" alt="Imágen buscar">

                            <p>
                                <strong>Agregar nuevo solicitud:</strong>
                                puede agregar una nueva solicitud haciendo click el el botón "Agregar nueva solicitud" esta acción deplegará una ventana modal
                                en la cual se ingresará la información necesaria para el registro. Al hacer click en el botón "Guardar" se generará el registro con los datos
                                proporcionados. Al hacer click en cerrar se cerrará la ventana modal borrando la información proporcionada.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_modal_crear_catastro.jpg') }}" alt="Imágen modal crear">

                            <p>
                                Puede hacer busquedas de los archivos a solicitar por los siguientes criterios: Tomo, Localidad, Oficina, Tipo y Registro. Si el archivo se encuentra disponible
                                para ser solicitado aparecerá en el área de Resultado de busqueda.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_modal_crear_catastro_2.jpg') }}" alt="Imágen modal crear">

                            <p>
                                Para poder solicitar el archivo es necesario que se indique a que empleado se le asginara la entrega del archivo. La lista de empleados
                                que muestra esta sujeta a dos criterios: El primero, el empleado debe de estar presente, es decir debe de haber checado en el sistema de personal.
                                El segundo, la lista mostrará solo aquellos empleados que pertenecen al área del solicitador.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_modal_crear_catastro_3.jpg') }}" alt="Imágen modal crear">

                            <p>
                                Una vez hecho la asignación pude eliminarla haciendo click en el botón "Eliminar".
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_modal_crear_catastro_4.jpg') }}" alt="Imágen modal crear">

                            <p>
                                <strong>Editar solicitud:</strong>
                                cada solicitud tiene asociado tres botones de acciones, puede editar una solicitud haciendo click el el botón "Editar" esta acción deplegará una ventana modal
                                en la cual se mostrará la información de la solicitud para actualizar.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_editar_rpp.jpg') }}" alt="Imágen editar">

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_modal_crear_catastro_4.jpg') }}" alt="Imágen editar modal">

                            <p>
                                <strong>Borrar solicitud:</strong>
                                puede borrar una solicitud haciendo click el el botón "Borrar" esta acción deplegará una ventana modal
                                en la cual se mostrará una advertencia, dando la opcion de cancelar o borrar la información.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_borrar_rpp.jpg') }}" alt="Imágen borrar">

                            <p>
                                Puede ver la información general de la solicitud haciendo click en el botón "Ver"
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/solicitudes_ver_catastro.jpg') }}" alt="Imágen borrar">

                        </div>

                    </div>

                    <div class="capitulo mb-10" id="distribuidor">

                        <h2 class="text-2xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-6  bg-white">Distribucion</h2>

                        <div class="  px-3">

                            <p class="mb-2">
                                La sección de distribución lleva el control de la distribución de los archivos solicitados  mediante surtidores.
                            </p>

                            <p>
                                <strong>Busqueda de archivo:</strong>
                                puede hacer busqueda de archvo por cualquiera de las columnas que muestra la tabla.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/distribucion_buscar_rpp.jpg') }}" alt="Imágen buscar">

                            <p>
                                <strong>Asignar archivo:</strong>
                                puede asigna un archivo haciendo click el el botón "Asignar" esta acción deplegará una ventana modal
                                en la cual se ingresará la información necesaria para el registro. Al hacer click en el botón "Asignar" se generará el registro con los datos
                                proporcionados. Al hacer click en cerrar se cerrará la ventana modal borrando la información proporcionada.
                            </p>

                            <img class="mb-4 mt-4 rounded mx-auto" src="{{ asset('storage/img/manual/distribucion_modal_crear.jpg') }}" alt="Imágen modal crear">

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>

        const btn_close = document.getElementById('sidebar-menu-button');
        const btn_open = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');

        btn_open.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        btn_close.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        /* Change nav profile image */
        window.addEventListener('nav-profile-img', event => {

            document.getElementById('nav-profile').setAttribute('src', event.detail.img);

        });

    </script>

</x-app-layout>
