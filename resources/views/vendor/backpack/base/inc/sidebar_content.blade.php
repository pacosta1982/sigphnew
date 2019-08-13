<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>

<li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
      <li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
      <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
    </ul>
  </li>
<li class="treeview">
        <a href="#"><i class="fa fa-check-square-o"></i> <span>Asignaciones</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
                <li><a href='{{ backpack_url('modalidad_land') }}'><i class='fa fa-tag'></i> <span>Modalidad - Tierra</span></a></li>
                <li><a href='{{ backpack_url('land_project') }}'><i class='fa fa-tag'></i> <span>Tierra - Tipo Proyecto</span></a></li>
                <li><a href='{{ backpack_url('assignment') }}'><i class='fa fa-tag'></i> <span>Tipo Proyecto - Documentos</span></a></li>
                <li><a href='{{ backpack_url('project_tipologies') }}'><i class='fa fa-tag'></i> <span>Tipo Proyecto - Tipologias</span></a></li>
        </ul>
</li>
<li class="treeview">
        <a href="#"><i class="fa fa-file"></i> <span>Mantenimiento</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
                <li><a href='{{ backpack_url('modality') }}'><i class='fa fa-tag'></i> <span>Modalidades</span></a></li>
                <li><a href='{{ backpack_url('land') }}'><i class='fa fa-tag'></i> <span>Terrenos</span></a></li>
                <li><a href='{{ backpack_url('document') }}'><i class='fa fa-tag'></i> <span>Documentos</span></a></li>
                <li><a href='{{ backpack_url('category') }}'><i class='fa fa-tag'></i> <span>Categorias</span></a></li>
                <li><a href='{{ backpack_url('usuarios') }}'><i class='fa fa-tag'></i> <span>Usuarios</span></a></li>
                <li><a href='{{ backpack_url('project_type') }}'><i class='fa fa-tag'></i> <span>Tipos Proyectos</span></a></li>
                <li><a href='{{ backpack_url('stage') }}'><i class='fa fa-tag'></i> <span>Etapas</span></a></li>
                <li><a href='{{ backpack_url('typology') }}'><i class='fa fa-tag'></i> <span>Tipologias</span></a></li>
                <li><a href='{{ backpack_url('parentesco') }}'><i class='fa fa-tag'></i> <span>Parentesco</span></a></li>
                <li><a href='{{ backpack_url('discapacidad') }}'><i class='fa fa-tag'></i> <span>Discapacidad</span></a></li>
        </ul>
</li>


