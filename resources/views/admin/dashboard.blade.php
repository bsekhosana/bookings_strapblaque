@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-fw fa-home"></i></div>
                            Dashboard
                        </h1>
                        <div class="page-header-subtitle">Overview and content summary</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="row">
            <div class="col-xl-4 mb-4">
                <!-- Dashboard example card 1-->
                <a class="card lift h-100" href="#!">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <i class="fas fa-fw fa-box text-primary mb-3" style="font-size: 2rem;"></i>
                                <h5>Powerful Components</h5>
                                <div class="text-muted small">To create informative visual elements on your pages</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 mb-4">
                <!-- Dashboard example card 2-->
                <a class="card lift h-100" href="#!">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <i class="fas fa-fw fa-book text-primary mb-3" style="font-size: 2rem;"></i>
                                <h5>Documentation</h5>
                                <div class="text-muted small">To keep you on track when working with our toolkit</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 mb-4">
                <!-- Dashboard example card 3-->
                <a class="card lift h-100" href="#!">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <i class="fas fa-fw fa-table text-primary mb-3" style="font-size: 2rem;"></i>
                                <h5>Pages &amp; Layouts</h5>
                                <div class="text-muted small">To help get you started when building your new UI</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-8">
                <!-- Tabbed dashboard card example-->
                <div class="card mb-4">
                    <div class="card-header border-bottom">
                        <!-- Dashboard card navigation-->
                        <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                            <li class="nav-item me-1"><a class="nav-link active" id="overview-pill" href="#overview" data-bs-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Overview</a></li>
                            <li class="nav-item"><a class="nav-link" id="activities-pill" href="#activities" data-bs-toggle="tab" role="tab" aria-controls="activities" aria-selected="false">Activities</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="dashboardNavContent">
                            <!-- Dashboard Tab Pane 1-->
                            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-pill">
                                <div class="chart-area mb-4 mb-lg-0" style="height: 20rem"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
                            </div>
                            <!-- Dashboard Tab Pane 2-->
                            <div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="activities-pill">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 mb-4">
                        <!-- Dashboard activity timeline example-->
                        <div class="card card-header-actions h-100">
                            <div class="card-header">
                                Recent Activity
                                <div class="dropdown no-caret">
                                    <button class="btn btn-icon dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-ellipsis-vertical text-gray-500"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownMenuButton">
                                        <h6 class="dropdown-header">Filter Activity:</h6>
                                        <a class="dropdown-item" href="#!"><span class="badge bg-green-soft text-green my-1">Commerce</span></a>
                                        <a class="dropdown-item" href="#!"><span class="badge bg-blue-soft text-blue my-1">Reporting</span></a>
                                        <a class="dropdown-item" href="#!"><span class="badge bg-yellow-soft text-yellow my-1">Server</span></a>
                                        <a class="dropdown-item" href="#!"><span class="badge bg-purple-soft text-purple my-1">Users</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="timeline timeline-xs">
                                    <!-- Timeline Item 1-->
                                    <div class="timeline-item">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">27 min</div>
                                            <div class="timeline-item-marker-indicator bg-green"></div>
                                        </div>
                                        <div class="timeline-item-content">
                                            New order placed!
                                            <a class="fw-bold" href="#!">Order #2912</a>
                                            has been successfully placed.
                                        </div>
                                    </div>
                                    <!-- Timeline Item 2-->
                                    <div class="timeline-item">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">58 min</div>
                                            <div class="timeline-item-marker-indicator bg-blue"></div>
                                        </div>
                                        <div class="timeline-item-content">
                                            Your
                                            <a class="fw-bold" href="#!">weekly report</a>
                                            has been generated and is ready to view.
                                        </div>
                                    </div>
                                    <!-- Timeline Item 3-->
                                    <div class="timeline-item">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">2 hrs</div>
                                            <div class="timeline-item-marker-indicator bg-purple"></div>
                                        </div>
                                        <div class="timeline-item-content">
                                            New user
                                            <a class="fw-bold" href="#!">Valerie Luna</a>
                                            has registered
                                        </div>
                                    </div>
                                    <!-- Timeline Item 4-->
                                    <div class="timeline-item">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">1 day</div>
                                            <div class="timeline-item-marker-indicator bg-yellow"></div>
                                        </div>
                                        <div class="timeline-item-content">Server activity monitor alert</div>
                                    </div>
                                    <!-- Timeline Item 5-->
                                    <div class="timeline-item">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">1 day</div>
                                            <div class="timeline-item-marker-indicator bg-green"></div>
                                        </div>
                                        <div class="timeline-item-content">
                                            New order placed!
                                            <a class="fw-bold" href="#!">Order #2911</a>
                                            has been successfully placed.
                                        </div>
                                    </div>
                                    <!-- Timeline Item 6-->
                                    <div class="timeline-item">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">1 day</div>
                                            <div class="timeline-item-marker-indicator bg-purple"></div>
                                        </div>
                                        <div class="timeline-item-content">
                                            Details for
                                            <a class="fw-bold" href="#!">Marketing and Planning Meeting</a>
                                            have been updated.
                                        </div>
                                    </div>
                                    <!-- Timeline Item 7-->
                                    <div class="timeline-item">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">2 days</div>
                                            <div class="timeline-item-marker-indicator bg-green"></div>
                                        </div>
                                        <div class="timeline-item-content">
                                            New order placed!
                                            <a class="fw-bold" href="#!">Order #2910</a>
                                            has been successfully placed.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 mb-4">
                        <!-- Pie chart with legend example-->
                        <div class="card h-100">
                            <div class="card-header">Traffic Sources</div>
                            <div class="card-body">
                                <div class="chart-pie mb-4"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item d-flex align-items-center justify-content-between small px-0 py-2">
                                        <div class="me-3">
                                            <i class="fas fa-circle fa-sm me-1 text-blue"></i>
                                            Direct
                                        </div>
                                        <div class="fw-500">55%</div>
                                    </div>
                                    <div class="list-group-item d-flex align-items-center justify-content-between small px-0 py-2">
                                        <div class="me-3">
                                            <i class="fas fa-circle fa-sm me-1 text-purple"></i>
                                            Social
                                        </div>
                                        <div class="fw-500">15%</div>
                                    </div>
                                    <div class="list-group-item d-flex align-items-center justify-content-between small px-0 py-2">
                                        <div class="me-3">
                                            <i class="fas fa-circle fa-sm me-1 text-green"></i>
                                            Referral
                                        </div>
                                        <div class="fw-500">30%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4">
                <div class="row">
                    <div class="col-xl-6 col-xxl-12">
                        <!-- Team members / people dashboard card example-->
                        <div class="card mb-4">
                            <div class="card-header">People</div>
                            <div class="card-body">
                                <!-- Item 1-->
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center flex-shrink-0 me-3">
                                        <div class="avatar avatar-xl me-3 bg-gray-200"><img class="avatar-img img-fluid" src="{{ asset('images/placeholders/avatar.png') }}" alt="" /></div>
                                        <div class="d-flex flex-column fw-bold">
                                            <a class="line-height-normal mb-1" href="#!">Sid Rooney</a>
                                            <div class="small text-muted line-height-normal">Position</div>
                                        </div>
                                    </div>
                                    <div class="dropdown no-caret">
                                        <button class="btn btn-icon dropdown-toggle" id="dropdownPeople1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-ellipsis-vertical"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownPeople1">
                                            <a class="dropdown-item" href="#!">Action</a>
                                            <a class="dropdown-item" href="#!">Another action</a>
                                            <a class="dropdown-item" href="#!">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Item 2-->
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center flex-shrink-0 me-3">
                                        <div class="avatar avatar-xl me-3 bg-gray-200"><img class="avatar-img img-fluid" src="{{ asset('images/placeholders/avatar.png') }}" alt="" /></div>
                                        <div class="d-flex flex-column fw-bold">
                                            <a class="line-height-normal mb-1" href="#!">Keelan Garza</a>
                                            <div class="small text-muted line-height-normal">Position</div>
                                        </div>
                                    </div>
                                    <div class="dropdown no-caret">
                                        <button class="btn btn-icon dropdown-toggle" id="dropdownPeople2" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-ellipsis-vertical"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownPeople2">
                                            <a class="dropdown-item" href="#!">Action</a>
                                            <a class="dropdown-item" href="#!">Another action</a>
                                            <a class="dropdown-item" href="#!">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Item 3-->
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center flex-shrink-0 me-3">
                                        <div class="avatar avatar-xl me-3 bg-gray-200"><img class="avatar-img img-fluid" src="{{ asset('images/placeholders/avatar.png') }}" alt="" /></div>
                                        <div class="d-flex flex-column fw-bold">
                                            <a class="line-height-normal mb-1" href="#!">Kaia Smyth</a>
                                            <div class="small text-muted line-height-normal">Position</div>
                                        </div>
                                    </div>
                                    <div class="dropdown no-caret">
                                        <button class="btn btn-icon dropdown-toggle" id="dropdownPeople3" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-ellipsis-vertical"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownPeople3">
                                            <a class="dropdown-item" href="#!">Action</a>
                                            <a class="dropdown-item" href="#!">Another action</a>
                                            <a class="dropdown-item" href="#!">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Item 4-->
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center flex-shrink-0 me-3">
                                        <div class="avatar avatar-xl me-3 bg-gray-200"><img class="avatar-img img-fluid" src="{{ asset('images/placeholders/avatar.png') }}" alt="" /></div>
                                        <div class="d-flex flex-column fw-bold">
                                            <a class="line-height-normal mb-1" href="#!">Kerri Kearney</a>
                                            <div class="small text-muted line-height-normal">Position</div>
                                        </div>
                                    </div>
                                    <div class="dropdown no-caret">
                                        <button class="btn btn-icon dropdown-toggle" id="dropdownPeople4" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-ellipsis-vertical"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownPeople4">
                                            <a class="dropdown-item" href="#!">Action</a>
                                            <a class="dropdown-item" href="#!">Another action</a>
                                            <a class="dropdown-item" href="#!">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Item 5-->
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center flex-shrink-0 me-3">
                                        <div class="avatar avatar-xl me-3 bg-gray-200"><img class="avatar-img img-fluid" src="{{ asset('images/placeholders/avatar.png') }}" alt="" /></div>
                                        <div class="d-flex flex-column fw-bold">
                                            <a class="line-height-normal mb-1" href="#!">Georgina Findlay</a>
                                            <div class="small text-muted line-height-normal">Position</div>
                                        </div>
                                    </div>
                                    <div class="dropdown no-caret">
                                        <button class="btn btn-icon dropdown-toggle" id="dropdownPeople5" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-ellipsis-vertical"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownPeople5">
                                            <a class="dropdown-item" href="#!">Action</a>
                                            <a class="dropdown-item" href="#!">Another action</a>
                                            <a class="dropdown-item" href="#!">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Item 6-->
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center flex-shrink-0 me-3">
                                        <div class="avatar avatar-xl me-3 bg-gray-200"><img class="avatar-img img-fluid" src="{{ asset('images/placeholders/avatar.png') }}" alt="" /></div>
                                        <div class="d-flex flex-column fw-bold">
                                            <a class="line-height-normal mb-1" href="#!">Wilf Ingram</a>
                                            <div class="small text-muted line-height-normal">Position</div>
                                        </div>
                                    </div>
                                    <div class="dropdown no-caret">
                                        <button class="btn btn-icon dropdown-toggle" id="dropdownPeople6" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-ellipsis-vertical"></i></button>
                                        <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownPeople6">
                                            <a class="dropdown-item" href="#!">Action</a>
                                            <a class="dropdown-item" href="#!">Another action</a>
                                            <a class="dropdown-item" href="#!">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-xxl-12">
                        <!-- Project tracker card example-->
                        <div class="card card-header-actions mb-4">
                            <div class="card-header">
                                Projects
                                <a class="btn btn-sm btn-primary-soft text-primary" href="#!">Create New</a>
                            </div>
                            <div class="card-body">
                                <!-- Progress item 1-->
                                <div class="d-flex align-items-center justify-content-between small mb-1">
                                    <div class="fw-bold">Server Setup</div>
                                    <div class="small">25%</div>
                                </div>
                                <div class="progress mb-3"><div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>
                                <!-- Progress item 2-->
                                <div class="d-flex align-items-center justify-content-between small mb-1">
                                    <div class="fw-bold">Database Migration</div>
                                    <div class="small">50%</div>
                                </div>
                                <div class="progress mb-3"><div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div></div>
                                <!-- Progress item 3-->
                                <div class="d-flex align-items-center justify-content-between small mb-1">
                                    <div class="fw-bold">Version Release</div>
                                    <div class="small">75%</div>
                                </div>
                                <div class="progress mb-3"><div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div></div>
                                <!-- Progress item 4-->
                                <div class="d-flex align-items-center justify-content-between small mb-1">
                                    <div class="fw-bold">Product Listings</div>
                                    <div class="small">100%</div>
                                </div>
                                <div class="progress"><div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/admin/chart-area-demo.js', 'resources/js/admin/chart-bar-demo.js', 'resources/js/admin/chart-pie-demo.js'])
@endpush