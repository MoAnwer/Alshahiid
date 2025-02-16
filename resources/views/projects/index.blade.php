@include('components.header', ['page_title' => ' قائمة المشاريع'])

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
              <a href="{{route('home') }}">الرئيسية</a>
              /               
            </li>
            <li class="breadcrumb-item active mx-1" >
              قائمة المشاريع
            </li>
          </ol>
        </nav>

        <hr>

        @php
          $totalBudget = 0;
          $totalBudgetFromOrg = 0;
          $totalBudgetOutOfOrg = 0;
          $totalMonthly = 0;
          $totalEx = 0;
          $totalMoney = 0;
        @endphp

        <div class="d-flex justify-content-between align-items-center px-3">
          <h4> قائمة المشاريع</h4>

           @if (request()->query('show') == 'true' || empty(request()->query('show')))
            
            {{-- Show btns --}}
              @if (is_null(request()->query('hiddenNotesAndActions')) || request()->query('hiddenNotesAndActions') == 'true')
                <a class="btn btn-info active  mr-2" href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'false']) }}" >
                  <i class="bi bi-eye-slash ml-2"></i>
                  إخفاء زر  المعمليات
                </a>
              @else
                <a class=" mr-2 btn btn-success active " href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'true']) }}" >
                  <i class="bi bi-eye ml-2"></i>
                    عرض  زر المعمليات
                </a>
              @endif
            {{--/ Show btns --}}

          @endif

        </div>

        <hr>

        <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row px-1 mt-4">
  
              <div class="col-1">
                <label>بحث باستخدام :</label>
                <div class="form-group">
                    <select name="search" class="form-select">
                      <option value="all"> --- </option>
                      <option value="martyr_name"  @selected(request('search') == 'martyr_name')>اسم الشهيد</option>
                      <option value="force"  @selected(request('search') == 'force')>قوة الشهيد</option>
                      <option value="project_name" @selected(request('search') == 'project_name')>اسم المشروع</option>
                      <option value="manager_name"  @selected(request('search') == 'manager_name')>اسم المدير</option>
                    </select>
                  </div>
              </div>


              <div class="col-1">
                <label>القيمة: </label>
                <div class="form-group">
                  <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
                </div>
              </div>
              
              <div class="col-1">
                <label>نوع المشروع :</label>
                <div class="form-group">
                    <select name="project_type" class="form-select">
                      <option value="all">الكل</option>
                      <option value="فردي"  @selected(request('project_type') == 'فردي')>فردي</option>
                      <option value="جماعي" @selected(request('project_type') == 'جماعي')>جماعي</option>
                    </select>
                  </div>
              </div>
              
              <div class="col-1">
                <label> الحالة :</label>
                <div class="form-group">
                    <select name="status" class="form-select">
                      <option value="all">الكل</option>
                      <option value="مطلوب"  @selected(request('status') == 'مطلوب')>مطلوب</option>
                      <option value="منفذ" @selected(request('status') == 'منفذ')>منفذ</option>
                    </select>
                  </div>
              </div>
              
              <div class="col-1">
                <label> الحالة التشغيلية :</label>
                <div class="form-group">
                    <select name="work_status" class="form-select">
                      <option value="all">الكل</option>
                      <option value="يعمل"  @selected(request('work_status') == 'يعمل')>يعمل</option>
                      <option value="لا يعمل" @selected(request('work_status') == 'لا يعمل')>لا يعمل</option>
                    </select>
                  </div>
              </div>

              <div class="col-2">
                <label>القطاع :</label>
                <div class="form-group">
                    <select name="sector" class="form-select">
                      <option value="all">كل القطاعات</option>
                      <option value="القطاع الشرقي"  @selected(request('sector') == 'القطاع الشرقي')>القطاع الشرقي</option>
                      <option value="القطاع الشمالي" @selected(request('sector') == 'القطاع الشمالي')>القطاع الشمالي</option>
                      <option value="القطاع الغربي"  @selected(request('sector') == 'القطاع الغربي')>القطاع الغربي</option>
                    </select>
                  </div>
              </div>

              <div class="col-2">
                  <label>المحلية: </label>
                  <div class="form-group">
                    <select name="locality" class="form-select">
                      <option value="all">كل المحليات </option>
                      @foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
                        <option value="{{ $locality }}" @selected(request('locality') == $locality)>{{ $locality }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>

              <div class="col-1">
                  <label>السنة: </label>
                  <div class="form-group">
                    <input type="number" class="py-4 form-control" max="2100" min="1900" step="1" name="year" value="{{ request('year') }}" />
                  </div>
                </div>

              <div class="col-1">
                  <label>الشهر: </label>
                  <div class="form-group">
                    <input type="number" class="py-4 form-control" min="1" max="12" step="1" name="month" value="{{ request('month') }}" />
                  </div>
                </div>

              <div class="col-1  d-flex align-items-center">
              <div class="mt-3 d-flex align-items-center flex-column justify-content-center mx-1">
                <button class="btn py-4 btn-primary active form-control " title="بحث ">
                  <i class="bi bi-search ml-2"></i>
                </button>
              </div>

              <div class="mt-3 d-flex align-items-center flex-column justify-content-center">
              <a class="btn py-4 btn-success active form-control " title="الغاء الفلاتر" href="{{ request()->url() }}">
                  <i class="bi bi-menu-button ml-2"></i>
                </a>
              </div>

              </div>

            </form>

            </div>
        </div>


 
          <x-table>
            <x-slot:head>
              <th>اسرة الشهيد</th>
              <th>سكن الاسرة</th>
              <th>اسم المشروع</th>
              <th>النوع</th>
              <th>الحالة</th>
              <th>الحالة التشغيلية</th>
              <th>التقديري</th>
              <th>المدير</th>
              <th>من  داخل المنظمة</th>
              <th>من  خارج المنظمة</th>
              <th>المبلغ المؤمن</th>
              <th>الدخل الشهري</th>
              <th>المصروفات</th>
              <th>تم الانشاء في</th>
              @if (request()->query('hiddenNotesAndActions') == 'true' || is_null(request()->query('hiddenNotesAndActions')))
               <th>عمليات</th>
              @endif
            </x-slot:head>

          <x-slot:body>
             @forelse($projects as $project)
              <tr>
                <td>{{ $project->martyr_name }}</td>
                <td>{{ $project->sector . ' - '. $project->locality }}</td>
                <td>{{ $project->project_name }}</td>
                <td>{{ $project->project_type }}</td>
                <td>{{ $project->status }}</td>
                <td>{{ $project->work_status }}</td>

                <td>{{ number_format($project->budget) }}</td>
                @php($totalBudget += $project->budget)
                
                <td>{{ !empty($project->manager_name) ? $project->manager_name : '-' }}</td>

                <td>{{ number_format($project->budget_from_org) ?? '-' }}</td>
                @php($totalBudgetFromOrg += $project->budget_from_org)

                <td>{{ number_format($project->budget_out_of_org ) ?? '-' }}</td>
                @php($totalBudgetOutOfOrg += $project->budget_out_of_org)

                <td>{{ number_format($project->budget_from_org + $project->budget_out_of_org) ?? '-' }}</td>
                @php($totalMoney += $project->budget_from_org + $project->budget_out_of_org )

                <td>{{ number_format($project->monthly_budget) }}</td>
                @php($totalMonthly += $project->monthly_budget)

                <td>{{ number_format($project->expense) }}</td>
                @php($totalEx += $project->expense)

                <td>{{ date('Y-m-d', strtotime($project->created_at)) }}</td>

                @if (request()->query('hiddenNotesAndActions') == 'true' || is_null(request()->query('hiddenNotesAndActions')))
               <td>
                <a href="{{ route('projects.edit', $project->project_id) }}" class="btn btn-success p-2 fa-sm">
                  <i class="bi bi-pen" title="تعديل"></i>
                </a>
                <a href="{{ route('projects.delete', $project->project_id) }}" class="btn btn-danger p-2 fa-sm">
                  <i class="bi bi-trash-fill" title="حذف"></i>
                </a>
                </td>
                @endif

                
                </tr>
              @empty
			          <tr>
				           <td colspan="15">لا توجد مشاريع</td>
			          </tr>
              @endforelse

              <caption>
                
                قائمة المشاريع 

                @if(request()->query('search') == 'martyr_name')
                اسرة الشهيد {{ request()->query('needel') }}
                @endif

                 @if(request()->query('search') == 'force')
                  اسر {{ request()->query('needel') }}
                @endif

                     
                @if(!is_null(request()->query('relation')) && request()->query('relation') != 'all')
                 - {{ request()->query('relation') }} - 
                @endif

                @if(!is_null(request()->query('gender')) && request()->query('gender') != 'all')
                 {{ request()->query('gender') }} -
                @endif
                
                
                @if(!is_null(request()->query('type')) && request()->query('type') != 'all')

                  خدمات {{  request()->query('type') }} 
                    @if (!is_null(request()->query('status')) && request()->query('status') != 'all')

                    {{ ' ' . request()->query('status') != 'all' ? request()->query('status'). 'ة' : '' }} 

                  @endif
                @endif
                
                @if (request()->query('type') == 'all' && !is_null(request()->query('status')) && request()->query('status') != 'all')

                  خدمات {{ ' ' . request()->query('status') != 'all' ? request()->query('status'). 'ة' : '' }} 

                @endif

                @if(request()->query('sector') == 'all' && !is_null(request()->query('sector')))

                  @if (request()->query('locality') != 'all')

                    {{ '' }}
                    
                  @endif
                @else
                {{ request()->query('sector') ?? 'كل القطاعات'}}
                @endif
  
                @if(request()->query('locality') == 'all' && !is_null(request()->query('locality')))
                  @if (request()->query('locality') != 'all')
                    {{ '' }}
                  @endif
                @else
                {{ request()->query('locality') ?? 'كل المحليات'}}
                @endif
                
                @if(request()->query('year') == '' && is_null(request()->query('year')))
                  لكل السنوات
                @else
                  سنة {{ request()->query('year') }}
                @endif

                @if(request()->query('month') == '' && is_null(request()->query('month')))
                  لكل الشهور 
                @else
                  شهر {{ request()->query('month') }}
                @endif

              </caption>

            </x-slot:body>
          </x-table>

          {{ $projects->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}


          <hr>

          <div class="d-flex align-items-center justify-content-between py-4 mb-5">
             <h5>
                العدد الكلي :
                <span><b>{{ number_format($projects->total()) }}</b></span>
            </h5>
            <h5>
                اجمالي التقديري :
                <span><b>{{ number_format($totalBudget) }}</b></span>
            </h5>
            <h5>
                اجمالي من داخل المنظمة :
                <span><b>{{ number_format($totalBudgetFromOrg) }}</b></span>
            </h5>
            <h5>
                اجمالي من خارج المنظمة :
                <span><b>{{ number_format($totalBudgetOutOfOrg) }}</b></span>
            </h5>
            <h5>
                اجمالي المؤمن :
                <span><b>{{ number_format($totalMoney) }}</b></span>
            </h5>
            <h5>
                اجمالي الدخل الشهري :
                <span><b>{{ number_format($totalMonthly) }}</b></span>
            </h5>

            <h5>
                اجمالي المصروفات :
                <span><b>{{ number_format($totalEx) }}</b></span>
            </h5>

          </div>


        </div>

    </div>
  @include('components.footer')