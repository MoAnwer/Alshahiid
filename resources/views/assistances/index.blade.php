@include('components.header', ['page_title' => ' قائمة المساعدات'])

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
              قائمة المساعدات
            </li>
          </ol>
        </nav>

        <hr>


        <div class="d-flex justify-content-between align-items-center px-3">
          <h4> قائمة المساعدات</h4>

           @if (request()->query('show') != 'true')
              <a class="btn btn-success active" href="{{ request()->url() . '?show=true' }}" >
                <i class="bi bi-menu-app ml-2"></i>
                عرض كل المساعدات
              </a>
            @else
              <a class="btn btn-info active" href="{{ request()->url() . '?show=false' }}" >
                <i class="bi bi-x ml-2"></i>
                إخفاء كل المساعدات
              </a>
            @endif
        </div>

        <hr>

        @php
          $totalBudget = 0;
          $totalBudgetFromOrg = 0;
          $totalBudgetOutOfOrg = 0;
          $totalMoney = 0;
        @endphp

        <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row px-1 mt-4">
  
              <div class="col-2">
                <label>بحث باستخدام :</label>
                <div class="form-group">
                    <select name="search" class="form-select">
                      <option value="all"> --- </option>
                      <option value="martyr_name" @selected(request('search') == 'martyr_name')>اسم الشهيد</option>
                      <option value="force"  @selected(request('search') == 'force')>قوة الشهيد</option>
                    </select>
                  </div>
              </div>


              <div class="col-2">
                <label>القيمة: </label>
                <div class="form-group">
                  <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
                </div>
              </div>
              
              <div class="col-2">
                <label>نوع المساعدة</label>
                <div class="form-group">
                  <select name="type" class="form-select">
                    <option value="all" @selected('all' == request()->query('type'))>الكل</option>
                    @foreach ([
                      'افطار الصائم',
                      'اكرامية عيد الفطر',
                      'اكرامية عيد الاضحي',
                      'إعانات طارئة',
                      'مساعدات',
                      'سفر و انتقال',
                      'احتفالات',
                      'راعي و رعية',
                      'قوت عام',
                      'زيارات المشرفين',
                      'صيانة سكن',
                      'إيجار',
                      'رسوم سكن',
                      'رسوم مشروعات',
                      'تأهيل مشروعات',
                      'دعم استراتيجي'
                    ] as $type)
                  <option value="{{ $type }}" @selected($type == request()->query('type'))>{{ $type }}</option>
                @endforeach
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


 
          @if (request()->query('show') == 'true' || !empty(request()->query('search')))

          <x-table>
            <x-slot:head>

            @if (request()->query('search') !== 'martyr_name')
              <th>اسرة الشهيد</th>
            @endif
            @if (request()->query('search') !== 'force')
              <th>قوة الشهيد</th>
            @endif
            @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
              <th>القطاع</th>
              @endif
            @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
              <th>المحلية</th>
            @endif

            @if (request()->query('type') == 'all'|| is_null(request()->query('type')) )
              <th>النوع</th>
            @endif

            @if (request()->query('status') == 'all'|| is_null(request()->query('status')) )
                <th>الحالة</th>
            @endif

              <th>التقديري</th>
              <th>من  داخل المنظمة</th>
              <th>من  خارج المنظمة</th>
              <th> المبلغ المؤمن</th>
              <th>تم الانشاء في</th>
              {{-- <th>عمليات</th> --}}
            </x-slot:head>

          <x-slot:body>
             @forelse($assistances as $assistance)
              <tr>

                @if (request()->query('search') !== 'martyr_name')
                  <td>{{ $assistance->martyr_name }}</td>
                @endif

                @if (request()->query('search') !== 'force')
                  <td>{{ $assistance->force }}</td>
                @endif

                @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
                <td>{{ $assistance->sector }}</td> 
                @endif

                @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
                  <td>{{ $assistance->locality }}</td>
                @endif
                
                @if (request()->query('type') == 'all'|| is_null(request()->query('type')) )
                  <td>{{ $assistance->type }}</td>
                @endif
                
                @if (request()->query('status') == 'all'|| is_null(request()->query('status')) )
                  <td>{{ $assistance->status }}</td>
                @endif

                <td>{{ number_format($assistance->budget) }}</td>
                @php($totalBudget += $assistance->budget)
                
                <td>{{ number_format($assistance->budget_from_org) ?? '-' }}</td>
                @php($totalBudgetFromOrg += $assistance->budget_from_org)
                
                <td>{{ number_format($assistance->budget_out_of_org ) ?? '-' }}</td>
                @php($totalBudgetOutOfOrg += $assistance->budget_out_of_org)
                
                <td>{{ number_format($assistance->budget_from_org + $assistance->budget_out_of_org ) ?? '-' }}</td>
                @php($totalMoney += $assistance->budget_from_org + $assistance->budget_out_of_org)
                
                <td>{{ date('Y-m-d', strtotime($assistance->created_at)) }}</td>
                {{-- <td>
                  <a href="{{ route('assistances.edit', ['family' =>  $assistance->family_id, 'id' =>  $assistance->assistance_id]) }}" class="btn btn-success p-2 fa-sm">
                    <i class="bi bi-pen" title="تعديل"></i>
                  </a>
                  <a href="{{ route('assistances.delete', $assistance->assistance_id) }}" class="btn btn-danger p-2 fa-sm">
                    <i class="bi bi-trash-fill" title="حذف"></i>
                  </a>
                  </td> --}}
                </tr>
              @empty
			          <tr>
				           <td colspan="14">لا توجد مشاريع</td>
			          </tr>
              @endforelse


              <caption class="text-primary">

                @if(request()->query('search') == 'martyr_name')
                اسرة الشهيد {{ request()->query('needel') }}
                @endif
                
                @if(!is_null(request()->query('type')) && request()->query('type') != 'all')

                  مساعدات {{  request()->query('type') }} 
                    @if (!is_null(request()->query('status')) && request()->query('status') != 'all')

                    {{ ' ' . request()->query('status') != 'all' ? request()->query('status'). 'ة' : '' }} 

                  @endif
                @endif
                
                @if (request()->query('type') == 'all' && !is_null(request()->query('status')) && request()->query('status') != 'all')

                  مساعدات {{ ' ' . request()->query('status') != 'all' ? request()->query('status'). 'ة' : '' }} 

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

          
          {{ $assistances->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}
          
          <hr>

          <div class="d-flex align-items-center justify-content-between  py-4 mb-5">
             <h5>
                العدد الكلي :
                <span><b>{{ number_format($assistances->total()) }}</b></span>
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
          </div>

          @else

            <div class="text-center p-5 mx-auto my-5">
              <h3>ادخل  اسم الشهيد او قوته في حقل البحث لعرضه, او اضغط على عرض الكل لعرض كل المساعدات المقدمة لكل الاسر</h3>
            </div>
          
          @endif


        </div>

    </div>
  @include('components.footer')