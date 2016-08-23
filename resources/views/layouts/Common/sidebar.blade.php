<!-- 左侧边栏 -->
<aside class="main-sidebar">
    <section class="sidebar">

        <!-- 用户信息 -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ url('assets/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Session::get('user')->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
        </div>

        <!-- 搜索表单 -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>

        <ul class="sidebar-menu">
            <li class="header">后台管理</li>

            <li class="{{ Request::is('admin') ? 'active' : '' }}"><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> <span> 仪表盘</span></a></li>
            <li class="{{ Request::is('admin/apidoc') ? 'active' : '' }}"><a href="{{ url('admin/apidoc') }}"><i class="fa fa-sticky-note-o"></i> <span> API文档</span></a></li>

            {{-- 数据管理 --}}
            <li class="treeview {{ (Request::is('admin/category*') || Request::is('admin/video*')) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-database"></i> <span> 数据管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu" style="display: {{ (Request::is('admin/category*') || Request::is('admin/video*')) ? 'block' : 'none' }};">
                    <li class="{{ Request::is('admin/category/create') ? 'active' : '' }}"><a href="{{ url('admin/category/create') }}"><i class="fa fa-edit"></i> 添加分类</a></li>
                    <li class="{{ Request::is('admin/category') ? 'active' : '' }}"><a href="{{ url('admin/category') }}"><i class="fa fa-folder"></i> 管理分类</a></li>
                    <li class="{{ Request::is('admin/video/create') ? 'active' : '' }}"><a href="{{ url('admin/video/create') }}"><i class="fa fa-cloud-upload"></i> 添加视频</a></li>
                    <li class="{{ (Request::is('admin/video') || Request::is('admin/video/*/edit') || Request::is('admin/video/*/push')) ? 'active' : '' }}"><a href="{{ url('admin/video') }}"><i class="fa fa-list-alt"></i> 管理视频</a></li>
                </ul>
            </li>

            {{-- 系统管理 --}}
            <li class="treeview {{ (Request::is('admin/feedback') || Request::is('admin/option')) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-circle-o-notch"></i> <span> 系统管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu" style="display: {{ (Request::is('admin/option') || Request::is('admin/feedback')) ? 'block' : 'none' }};">
                    <li class="{{ Request::is('admin/feedback') ? 'active' : '' }}"><a href="{{ url('admin/feedback') }}"><i class="fa fa-reply-all"></i> 意见反馈</a></li>
                    <li class="{{ Request::is('admin/option') ? 'active' : '' }}"><a href="{{ url('admin/option') }}"><i class="fa fa-cog"></i> 系统设置</a></li>
                </ul>
            </li>

        </ul>

    </section>
</aside>

<!-- 右隐藏侧边栏 -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:;">
                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                            <p>Will be 23 on April 24th</p>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:;">
                        <h4 class="control-sidebar-subheading">
                            Custom Template Design
                <span class="pull-right-container">
                  <span class="label label-danger pull-right">70%</span>
                </span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading">General Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Report panel usage
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Some information about this general settings option
                    </p>
                </div>
                <!-- /.form-group -->
            </form>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<div class="control-sidebar-bg"></div>