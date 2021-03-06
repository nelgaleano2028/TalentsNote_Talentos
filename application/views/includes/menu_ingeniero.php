<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="wrapper">
<div id="layout-static">
<div class="static-sidebar-wrapper sidebar-bluegray">
    <div class="static-sidebar">
        <div class="sidebar">
            <div class="widget">
                <div class="widget-body">
                    <div class="userinfo" >
                        <div class="avatar">
                            <img src="<?php echo base_url()?>images/avatar_ing.png" class="img-responsive img-circle">
                        </div>
                        <div class="info">
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
                        <li><a href="javascript:;"><i class="ti ti-desktop"></i><span>Incidentes</span></a>
                            <ul class="acc-menu">
                                <li><a href="<?php echo base_url()?>ingeniero/ver_incidentes_clientes/<?php echo $login[0]['id_ingeniero'] ?>">Ver Incidentes</a></li>
                                <li><a href="<?php echo base_url()?>ingeniero/libreta">Libreta de direcciones</a></li> 
                                <li><a href="<?php echo base_url()?>ingeniero/ver_incidentes_resueltos/<?php echo $login[0]['id_ingeniero'] ?>">Incidentes Resueltos</a></li> 
                                <li><a href="<?php echo base_url()?>ingeniero/crear_incidentes">Crear incidentes</a></li>  
                            </ul>
                        </li>
                        <li><a href="<?php echo base_url()?>ingeniero/perfil_ingeniero/<?php echo $login[0]['id_ingeniero'] ?>"><i class="ti ti-user"></i><span>Perfil</span></a></li>
                        <li><a href="<?php echo base_url()?>ingeniero/reportes/<?php echo $login[0]['id_ingeniero'] ?>"><i class="ti ti-user"></i><span>Reportes</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>