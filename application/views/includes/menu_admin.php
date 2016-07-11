<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="wrapper">
<div id="layout-static">
<div class="static-sidebar-wrapper sidebar-bluegray">
    <div class="static-sidebar">
        <div class="sidebar">
            <div class="widget">
                <div class="widget-body">
                    <div class="userinfo"  >
                        <div class="avatar">
                            <img src="<?php echo base_url()?>images/avatar_admin.png" class="img-responsive img-circle">
                        </div>
                        <div class="info" >
                            <span class="username"><?php echo ucwords($login[0]['Usuario']);?></span><br>
                            <span class="useremail">
                                <?php 
                                if($login[0]['id_perfil']==1) {
                                    $rol="Administrador";
                                }elseif($login[0]['id_perfil']==2){
                                    $rol="Ingeniero";
                                }else{
                                    $rol="Cliente";
                                }
                                echo $rol;?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget stay-on-collapse" id="widget-sidebar">
                <nav class="widget-body">
                    <ul class="acc-menu">
                        <li class="nav-separator"><span>Menú</span></li>
                        <li><a href="javascript:;"><i class="ti ti-desktop"></i><span>Ingenieros</span></a>
                            <ul class="acc-menu">
                                <li><a href="<?php echo base_url()?>area">Ver Áreas</a></li> 
                                <li><a href="<?php echo base_url()?>cesantias">Ver Censantias</a></li> 
                                <li><a href="<?php echo base_url()?>eps">Ver Eps</a></li> 
                                <li><a href="<?php echo base_url()?>ingeniero/">Ver Ingeniero</a></li> 
                                <li><a href="<?php echo base_url()?>pensiones/">Ver Pensiones</a></li> 
                                <li><a href="<?php echo base_url()?>cargos/">Ver Cargo</a></li> 
                                <li><a href="<?php echo base_url()?>causa/">Ver Causa</a></li> 
                                <li><a href="<?php echo base_url()?>estado/">Ver Estado</a></li> 
                            </ul>
                        </li>
                        <li><a href="javascript:;"><i class="ti ti-user"></i><span>Usuarios</span></a>
                            <ul class="acc-menu">
                                <li><a href="<?php echo base_url()?>clientes/">Ver Clientes</a></li>
                                <li><a href="<?php echo base_url()?>contacto/">Ver Contacto</a></li>
                                <li><a href="<?php echo base_url()?>usuario/">Ver Usuarios</a></li>
                                <li><a href="<?php echo base_url()?>usuario/crear_cliente">Crear Usuarios Cliente</a></li>
                                <li><a href="<?php echo base_url()?>usuario/crear_ingeniero">Crear Usuarios Ingeniero</a></li>
                                <li><a href="<?php echo base_url()?>usuario/cambiar_contadmin">Cambiar contraseña Admin</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:;"><i class="ti ti-agenda"></i><span>Incidencias</span></a>
                            <ul class="acc-menu">
                                <li><a href="<?php echo base_url()?>incidencias/">Ver incidencias</a></li>
                                <li><a href="<?php echo base_url()?>categoria/">Ver categorias</a></li>
                                <li><a href="<?php echo base_url()?>subcategoria/">Ver subcategoria</a></li>
                                <li><a href="<?php echo base_url()?>tiempoprioridad/">Ver tiempo</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:;"><i class="ti ti-bar-chart"></i><span>Estadisticas</span></a>
                            <ul class="acc-menu">
                                <li><a href="<?php echo base_url()?>estadistica/ingenieros/">Realizadas</a></li>
                                <li><a href="<?php echo base_url()?>estadistica/ingenieros2/">No realizadas</a></li>
                                <li><a href="<?php echo base_url()?>estadistica/abierto_cerrado/">Casos abiertos Vs cerrados</a></li>
                                <li><a href="<?php echo base_url()?>estadistica/reportesatencion/">Tiempo de atención </a></li>
                                <li><a href="<?php echo base_url()?>estadistica/reportessolucion/">Tiempo de solución</a></li>
                                <li><a href="<?php echo base_url()?>estadistica/reportescatidadcasos/">Casos por empresa</a></li>
                                <li><a href="<?php echo base_url()?>estadistica/reportescatidadcasosingenieros/">Casos por ingeniero</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>