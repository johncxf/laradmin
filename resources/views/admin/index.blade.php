@extends('admin.layouts.app')
@section('title', '后台管理中心')
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <!-- 基本信息展示 -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">总用户数</span>
                            <span class="info-box-number">10000</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-plus"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">新注册用户</span>
                            <span class="info-box-number">2,000</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">UV</span>
                            <span class="info-box-number">41,410</span>
                        </div>
                    </div>
                </div>
                <div class="clearfix hidden-md-up"></div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-o-right"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">PV</span>
                            <span class="info-box-number">1111110</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.基本信息展示 -->
            <!-- 其他 -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="timeline">
                        <div class="time-label">
                            <span class="bg-green">2020年</span>
                        </div>
                        <div>
                            <i class="fas fa-clock bg-info"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> 2月下旬</span>
                                <h3 class="timeline-header"> 资源管理系统</h3>
                                <div class="timeline-body">
                                    <p>&nbsp;&nbsp;&nbsp;1.资源管理系统开发上线，用户上传分享自己的到平台，用户可以在下载模块下载自己所需的资源</p>
                                    <p>&nbsp;&nbsp;&nbsp;2.资源上传下载通过一套金币体系进行运行，上传者设置自己资源下载所需积分，用户下载需要消耗金币
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-clock bg-success"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> 2月上旬</span>
                                <h3 class="timeline-header"> 内容管理系统</h3>
                                <div class="timeline-body">
                                    <p>&nbsp;&nbsp;&nbsp;1.内容管理系统部分开发完成，包括栏目、文章、标签、分类、幻灯片、链接等部分的内容管理。</p>
                                    <p>&nbsp;&nbsp;&nbsp;2.网站前台部分基本开发完成，以bootstrap4为前端框架进行简单的布局。前台部分包括首页、
                                    登录、注册、个人主页模块等。
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-clock bg-yellow"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> 1月上旬</span>
                                <h3 class="timeline-header"> 基础功能优化</h3>
                                <div class="timeline-body">
                                    &nbsp;&nbsp;&nbsp;&nbsp;基础架构优化、菜单优化、登录功能用户表与管理员表分离。
                                </div>
                            </div>
                        </div>
                        <div class="time-label">
                            <span class="bg-red">2019年</span>
                        </div>
                        <div>
                            <i class="fas fa-clock bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> 12月下旬</span>
                                <h3 class="timeline-header"> 基础架构搭建完成</h3>
                                <div class="timeline-body">
                                    &nbsp;&nbsp;&nbsp;&nbsp;后台架构基本搭建完成，包括管理员登录、用户管理、系统设置、rbac权限角色、菜单管理等
                                </div>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-clock bg-green"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i>12月中旬</span>
                                <h3 class="timeline-header no-border"> 后台设计开发阶段</h3>
                                <div class="timeline-body">
                                    数据表结构设计、整体架构设计、开始开发。
                                </div>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-clock bg-yellow"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i>11月...</span>
                                <h3 class="timeline-header"> 构思整体架构</h3>
                                <div class="timeline-body">
                                    &nbsp;&nbsp;&nbsp;&nbsp;选定Laravel为后端开发基础框架，bootstrap和adminlte为前端框架，mysql数据库和redis作为数据存储进行整体架构的设计开发。
                                </div>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-clock bg-gray"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.其他 -->
        </div>
    </div>
@endsection
