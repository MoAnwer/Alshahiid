@include('components.header', ['page_title' => 'الخدمات الاجتماعية'])

<div id="wrapper">

    @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            @include('components.navbar')


            <div class="container-fluid mt-4">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">الرئيسية</a>
                            /
                        </li>
                        <li class="breadcrumb-item mx-1">
                            <a href="{{ route('families.list') }}">قائمة اسر الشهداء</a>
                        </li>

                        <li class="breadcrumb-item  mx-1">
                            <a href="{{ route('families.show', $family->id) }}">اسرة الشهيد {{ $family->martyr->name}}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            الخدمات الاجتماعية
                        </li>
                    </ol>
                </nav>

                <x-alert />

                <!-- Services -->
                <hr />

                <h3>الخدمات الاجتماعية</h3>
                <hr />

                {{-- Assistances --}}

                <div class="row mb-3 py-3">

                    <div class="col-sm-12 col-6 col-lg-6">
                        <a href="{{ route('assistances.family', $family->id) }}">
                            <div class="card text-center py-3 border border-warning">
                                <div class="card-body">
                                    <i class="bi bi-star-fill fs-1 text-warning mb-5"></i>
                                    <h5 class="card-title mb-3 mt-3">المساعدات </h5>
                                    <p class="card-text mb-3">مساعدات اسرة الشهيد {{ $family->martyr->name }}</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-6 col-6 col-sm-12">
                        <a href="{{ route('projects.family', $family->id) }}">
                            <div class="card text-center py-3 border border-info">
                                <div class="card-body">
                                    <i class="bi bi-coin fs-1 text-info mb-5"></i>
                                    <h5 class="card-title mb-3 mt-3"> مشاريع الاسرة </h5>
                                    <p class="card-text mb-3">مشاريع اسرة الشهيد {{ $family->martyr->name }}</p>
                                </div>
                            </div>
                        </a>
                    </div>


                </div>

                <hr>

                {{-- / Assistances --}}


                <!-- Porjects -->
                <div class="d-flex justify-content-between align-items-center px-3">
                    <a href='{{ route('projects.family', $family->id) }}'></a>
                </div>


                <!-- Homes -->

                <div class="d-flex justify-content-between align-items-center px-3">
                    <h5>مشاريع السكن</h5>
                    <a class="btn btn-primary active" href="{{ route('homes.create', $family->id) }}">اضافة مشروع جديد</a>
                </div>

                <x-table>
                    <x-slot:head>
                        <th>#</th>
                        <th>النوع</th>
                        <th>الحالة</th>
                        <th>المدير</th>
                        <th>التقديري</th>
                        <th>من داخل المنظمة</th>
                        <th>من خارج المنظمة</th>
                        <th>المبلغ المؤمن</th>
                        <th>ملاحظات</th>
                        <th>تم الانشاء في</th>
                        <th>عمليات</th>
                    </x-slot:head>

                    <x-slot:body>
                        @if($family->homeServices->isNotEmpty())
                        @foreach($family->homeServices as $homeService)
                        <tr>
                            <td>{{ $homeService->id }}</td>
                            <td>{{ $homeService->type }}</td>
                            <td>{{ $homeService->status }}</td>
                            <td>{{ $homeService->manager_name }}</td>
                            <td>{{ number_format($homeService->budget) }}</td>
                            <td>{{ number_format($homeService->budget_from_org) ?? '-' }}</td>
                            <td>{{ number_format($homeService->budget_out_of_org) ?? '-' }}</td>
                            <td>{{ number_format($homeService->budget_from_org + $homeService->budget_out_of_org) }}</td>
                            <td>{{ $homeService->notes ?? 'لايوجد' }}</td>
                            <td>{{ date('Y-m-d', strtotime($homeService->created_at)) }}</td>
                            <td>
                                <a href="{{ route('homes.edit', $homeService->id)}}" class="btn btn-success p-2 fa-sm">
                                    <i class="bi bi-pen" title="تعديل"></i>
                                </a>
                                <a href="{{ route('homes.delete',  ['home' => $homeService->id])}}" class="btn btn-danger p-2 fa-sm">
                                    <i class="bi bi-trash-fill" title="حذف"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="11">لا توجد مشاريع السكن</td>
                        </tr>
                        @endif
                    </x-slot:body>
                </x-table>
                <!--/ Homes -->

            </div>
        </div>
    </div>

    @include('components.footer')
