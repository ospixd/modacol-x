<!-- Sidebar menu-->
<?php
$UN_SALTO = "\r\n";
?>
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= media();?>/images/avatar.png" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?= $_SESSION['userData']['nombres'];?></p>
          <p class="app-sidebar__user-name"><?= $_SESSION['userData']['apellidos']; ?></p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['nombrerol']?></pclass=>
        </div>
      </div>
      <ul class="app-menu">
      <li>
          <a class="app-menu__item" href="<?= base_url(); ?>" target="_blank">
            <i class="app-menu__icon fa fas fa-globe" aria-hidden="true"></i>
              <span class="app-menu__label">Ir a la tienda</span>
          </a>
        </li>
        
      <?php if(!empty($_SESSION['permisos'][1]['r'])){ ?>
        <li>
          <a class="app-menu__item" href="<?= base_url(); ?>dashboard">
            <i class="app-menu__icon bi bi-speedometer"></i>
              <span class="app-menu__label">Dashboard</span>
          </a>
        </li>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][2]['r']) || !empty($_SESSION['permisos'][7]['r'])){ ?>
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon bi bi-people-fill"></i>
              <span class="app-menu__label">Usuarios</span>
            <i class="treeview-indicator bi bi-chevron-right"></i>
          </a>
          <ul class="treeview-menu">
          <?php if(!empty($_SESSION['permisos'][2]['r'])){?>
            <li><a class="treeview-item" href="<?= base_url(); ?>usuarios"><i class="icon bi bi-circle"></i></i> Usuarios</a></li>
          <?php } ?>
          <?php if(!empty($_SESSION['permisos'][7]['r'])){?>
            <li><a class="treeview-item" href="<?= base_url(); ?>roles"><i class="icon bi bi-circle"></i> Roles</a></li>
          <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][3]['r'])){ ?>
        <li>
          <a class="app-menu__item" href="<?= base_url(); ?>clientes">
            <i class="app-menu__icon bi bi-person-fill"></i>
              <span class="app-menu__label">Clientes</span>
          </a>
        </li>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][4]['r']) || !empty($_SESSION['permisos'][6]['r'])){ ?>
          <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-archive"></i>
              <span class="app-menu__label">Tienda</span>
            <i class="treeview-indicator bi bi-chevron-right"></i>
          </a>
          <ul class="treeview-menu">
          <?php if(!empty($_SESSION['permisos'][4]['r'])){?>
            <li><a class="treeview-item" href="<?= base_url(); ?>productos"><i class="icon bi bi-circle"></i></i> Productos</a></li>
            <?php } ?>
            <?php if(!empty($_SESSION['permisos'][6]['r'])){?>
            <li><a class="treeview-item" href="<?= base_url(); ?>categorias"><i class="icon bi bi-circle"></i>Categorias</a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][5]['r'])){ ?>
        <li>
          <a class="app-menu__item" href="<?= base_url(); ?>pedidos">
           <i class="app-menu__icon bi bi-cart-fill"></i>
            <span class="app-menu__label">Pedidos</span>
          </a>
        </li>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][MSUSCRIPCIONES]['r'])){ ?>
        <li>
          <a class="app-menu__item" href="<?= base_url(); ?>suscriptores">
           <i class="app-menu__icon fas fa-user-tie"></i>
            <span class="app-menu__label">Suscriptores</span>
          </a>
        </li>
        <?php } ?>
        <li>
          <a class="app-menu__item" href="<?= base_url(); ?>logout">
            <i class="app-menu__icon bi bi-box-arrow-right"></i>
              <span class="app-menu__label">Logout</span>
          </a>
        </li>
      </ul>
    </aside>