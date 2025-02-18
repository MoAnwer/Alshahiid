@include('components.header', ['page_title' => "خدمات العلاج الطبي  للايتام"])

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
            <li class="breadcrumb-item mx-1">
              <a href="{{ route('orphans.index') }}">قسم الايتام</a>
              /
            </li>
            <li  class="breadcrumb-item active">خدمات العلاج الطبي  للايتام</li>
          </ol>
        </nav>
        
        <hr>
        
      </div>

      <div class="container-fluid mt-4">

        <div class="d-flex justify-content-between align-items-center pl-3">
          <h3>خدمات العلاج الطبي  للايتام</h3>
            <div class="d-flex justify-content-between"> 
          @if (request()->query('show') != 'true')
              <a class="btn btn-success active" href="{{ request()->fullUrlWithQuery(['show' => 'true']) }}" >
                <i class="bi bi-menu-app ml-2"></i>
                عرض كل الخدمات
              </a>
            @else
              <a class="btn btn-info active" href="{{ request()->fullUrlWithQuery(['show' => 'false']) }}" >
                <i class="bi bi-x ml-2"></i>
                إخفاء كل الخدمات
              </a>
            @endif
            <div class="d-flex justify-content-between align-items-center px-3" style="width: fit-content">
             <button class="mx-4 btn btn-primary active form-control" onclick="printContainer()">
             <i class="bi bi-printer ml-2"></i>
               طباعة 
             </button>
            </div>
          </div>
        </div>
        <hr>

        @php
          $totalBudget = 0;
          $totalBudgetFromOrg = 0;
          $totalBudgetOutOfOrg = 0;
          $totalMoney = 0;
        @endphp
        
          <div class="search-form mx-3 mt-3">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row">
              <input type="hidden" value="true" name="show" />
              <div class="col-2">
                <label>بحث باستخدام :</label>
                <div class="form-group">
                    <select name="search" class="form-select">
                      <option value="">--</option>
                      <option value="name" @selected(request('search') == 'name')>اسم </option>
                      <option value="national_number" @selected(request('search') == 'national_number')>الرقم الوطني</option>
                      <option value="martyr_name"  @selected(request('search') == 'martyr_name')>اسم الشهيد</option>
                      <option value="force" @selected(request('search') == 'force')>القوة العسكرية للشهيد</option>
                    </select>
                </div>
              </div>

              
              <div class="col-2">
                <label>بحث عن: </label>
                <div class="form-group">
                  <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
                </div>
              </div>

              <div class="col-1">
                <label>النوع :</label>
                <div class="form-group">
                    <select name="gender" class="form-select">
                      <option value="all"  @selected(request('gender') == "all")>ذكور و إناث</option>
                      <option value="ذكر"  @selected(request('gender') == "ذكر")>ذكر</option>
                      <option value="أنثى" @selected(request('gender') == "أنثى")>أنثى</option>
                    </select>
                  </div>
              </div>


              <div class="col-2">
                <label>نوع الخدمة :</label>
                <div class="form-group">
                    <select name="type" class="form-select">
                      <option value="all">الكل</option>
                      <option value="التأمين الصحي" @selected(request('type') == 'التأمين الصحي')>التأمين الصحي</option>
                      <option value="علاج بالخارج" @selected(request('type') == 'علاج بالخارج')>علاج بالخارج</option>
                      <option value="علاج خارج المظلة" @selected(request('type') == 'علاج خارج المظلة')>علاج بالخارج</option>
                    </select>
                </div>
            </div>

            <div class="col-1">
                <label>حالة الخدمة :</label>
                <div class="form-group">
                    <select name="status" class="form-select">
                      <option value="all">الكل</option>
                      <option value="مطلوب" @selected(request('status') == 'مطلوب')>مطلوب</option>
                      <option value="منفذ" @selected(request('status') == 'منفذ')>منفذ</option>
                    </select>
                </div>
            </div>

            <div class="col-2">
              <label>القطاع :</label>
              <div class="form-group">
                  <select name="sector" class="form-select">
                    <option value="all"  @selected(request('sector') == "all")>كل القطاعات</option>
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
                    <option value="all"  @selected(request('sector') == "all")>كل المحليات</option>
                    @foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
                      <option value="{{ $locality }}" @selected(request('locality') == $locality)>{{ $locality }}</option>
                      @endforeach
                    </select>
                </div>
            </div>

              <div class="col-1">
                  <label>السنة: </label>
                  <div class="form-group">
                    <input type="number" class="py-4 form-control" max="2100" min="1900" step="1" name="year" value="{{ request('year') ?? 'all' }}" placeholder="{{ request('year') }}" />
                  </div>
                </div>

              <div class="col-1">
                  <label>الشهر: </label>
                  <div class="form-group">
                    <input type="number" class="py-4 form-control" min="1" max="12" step="1" name="month" value="{{ request('month') ?? 'all' }}" placeholder="{{ request('month')  }}" />
                  </div>
                </div>

              <div class="col-1 mt-3 d-flex align-items-center">
                <button class="btn py-3 px-2 btn-primary active form-control ml-2" title="بحث">
                  <i class="bi bi-search"></i>
                </button>
                <a class="btn py-3 px-2 btn-success active form-control " title="إلغاء الفلاتر" href="{{ request()->url() }}">
                  <i class="bi bi-menu-button"></i>
                </a>
              </div>
              


              </form>

            </div>
        </div>

        {{--  --}}

        @if (request()->query('show') == 'true' || !empty(request()->query('search')))

        <div id="printArea">
          <x-table>
          <x-slot:head>
            <th>اسم اليتيم</th>
            <th>العمر</th>
            
            @if (request()->query('search') != 'national_number')
                <th>الرقم الوطني</th>
            @endif

            @if (request()->query('search') != 'martyr_name')
              <th>الشهيد</th>
            @endif

            @if (request()->query('search') != 'force')
              <th>قوة الشهيد</th>
            @endif
            
            @if (request()->query('type') == 'all' || empty(request()->query('type')))
                <th>نوع الخدمة</th>
            @endif

            @if (request()->query('status') == 'all' || empty(request()->query('status')))
                <th>الحالة</th>
            @endif
            


            <th>التقديري</th>
            <th>من داخل المنظمة</th>
            <th>من خارج المنظمة</th>
            <th>المبلغ المؤمن</th>

            @if (request()->query('sector') == 'all' || empty(request()->query('sector')))
              <th>القطاع</th>
            @endif                

            @if (request()->query('locality') == 'all' | empty(request()->query('locality')))
              <th>المحلية</th>
            @endif  
          
          
            <th>تم الإنشاء في</th>
          </x-slot:head>

          <x-slot:body>
            @forelse ($orphans as $orphan)
              <tr>
                <td>{{ $orphan->name }}</td>
                @if (request()->query('search') != 'age')
                  <td>{{ $orphan->age }}</td>
                @endif

                @if (request()->query('search') != 'national_number')
                    <td>{{ $orphan->national_number }}</td>
                @endif

                @if (request()->query('search') != 'martyr_name')
                  <td>{{ @$orphan->martyr_name }}</td>
                @endif

                @if (request()->query('search') != 'force')
                  <td>{{ @$orphan->force }}</td>
                @endif

                @if (request()->query('type') == 'all' || empty(request()->query('type')))
                  <td>{{ $orphan->type }}</td>
                @endif

                @if (request()->query('status') == 'all' || empty(request()->query('status')))
                  <td>{{ $orphan->status }}</td>
                @endif
                <td>{{ number_format($orphan->budget) }}</td>
                @php($totalBudget += $orphan->budget)

                <td>{{ number_format($orphan->budget_from_org) }}</td>
                @php($totalBudgetFromOrg += $orphan->budget_from_org)

                <td>{{ number_format($orphan->budget_out_of_org) }}</td>
                @php($totalBudgetOutOfOrg += $orphan->budget_out_of_org)
                
                <td>{{ number_format($orphan->budget_from_org + $orphan->budget_out_of_org) }}</td>
                @php($totalMoney += $orphan->budget_out_of_org + $orphan->budget_from_org)
                     

                @if (request()->query('sector') == 'all' || empty(request()->query('sector')))
                  <td>{{ @$orphan->sector }}</td>
                @endif                

                @if (request()->query('locality') == 'all' || empty(request()->query('locality')) )
                  <td>{{ @$orphan->locality }}</td>
                @endif                

                
                <td>{{ date('Y-m-d', strtotime($orphan->created_at)) }}</td>
              </tr>
            @empty
              <tr><td colspan="15">لا توجد نتائج</td></tr>
            @endforelse

          <caption>
            
            <caption>
              @if (request()->query('type') != 'all' && !is_null(request()->query('type')))
                خدمات {{ request()->query('type') }} للايتام
              @else
              خدمات  العالج الطبي للايتام
              @endif

              @if (request()->query('search') == 'force')
                {{ request()->query('needel') }}
              @endif

              @if (request()->query('search') == 'martyr_name')
                 اسرة الشهيد {{ request()->query('needel') }}
              @endif

              
              @if (request()->query('status') != 'all' && !is_null(request()->query('status')))

                {{ ' ' . request()->query('status') != 'all' ? request()->query('status'). 'ة' : '' }} 

              @endif

              @if(!is_null(request()->query('gender')) && request()->query('gender') != 'all')
                 {{ request()->query('gender') }} -
              @endif
              
              @if(request()->query('sector') == 'all' || empty(request()->query('sector')))
               كل القطاعات
              @else
                {{ request()->query('sector') }}
              @endif

              @if(request()->query('locality') == 'all' || empty(request()->query('locality')))
               كل المحليات
              @else
                {{ request()->query('locality') }}
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


      {{ $orphans->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}

      
        <hr>

        <div class="d-flex align-items-center justify-content-between  py-4 mb-5">
            <h5>
              العدد الكلي :
              <span><b>{{ number_format($orphans->total()) }}</b></span>
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
        
      </div>
        
        @else

          <div class="text-center p-5 mx-auto my-5">
              <h3>قم بالبحث عن  اسم  اليتيم  او الشهيد في حقل البحث لعرضه, او اضغط على عرض كل الخدمات المقدمة للايتام</h3>
          </div>

        @endif

      </div>

    </div>

  @include('components.footer')
