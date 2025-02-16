@include('components.header', ['page_title' => "توثيق سير الشهداء"])

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
            <li  class="mr-1 breadcrumb-item active">توثيق سير الشهداء</li>
          </ol>
        </nav>

       <hr>       

        @php
          $totalBudget = 0;
          $totalBudgetFromOrg = 0;
          $totalBudgetOutOfOrg = 0;
          $totalMoney = 0;
        @endphp

        <div class="d-flex justify-content-between align-items-center px-3">
          <h4> توثيق سير الشهداء </h4>
        </div>
       <hr>
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
                      <option value="unit" @selected(request('search') == 'unit')> وحدة الشهيد </option>
                    </select>
                  </div>
              </div>


              <div class="col-2">
                <label>القيمة: </label>
                <div class="form-group">
                  <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
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
                <label> حالة التوثيق :</label>
                <div class="form-group">
                    <select name="isTrue" class="form-select">
                      <option value="all">الكل</option>
                      <option value="yes" @selected(request('isTrue') == 'yes')>مؤثق</option>
                      <option value="no" @selected(request('isTrue') == 'no')>غير مؤثق</option>
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
              @if (request()->query('search') !== 'martyr_name')
              <th>الشهيد</th>
              @endif
              @if (request()->query('search') !== 'force')
                <th>القوة</th>
              @endif
              <th>الوحدة</th>
              @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
                <th>القطاع</th>
                @endif
              @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
                <th>المحلية</th>
              @endif
              @if (is_null(request('isTrue')) || request('isTrue') == 'all' || request('isTrue') == 'no' )
                <th>الحالة</th>
                <th>التقديري</th>
                <th>من داخل المنظمة</th>
                <th>من خارج المنظمة </th>
                <th>المبلغ المؤمن</th>
                <th>تم الانشاء في</th>
              @endif
          </x-slot:head>

        <x-slot:body>
			     @forelse($martyr_docs as $doc)
              <tr>
                @if (request()->query('search') !== 'martyr_name')
                  <td>{{ $doc->martyr_name }}</td>
                @endif
                @if (request()->query('search') !== 'force')
                  <td>{{ $doc->force }}</td>
                @endif
                <td>{{ $doc->martyr_unit }}</td>
                  @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
                  <td>{{ $doc->sector  ?? '-'}}</td> 
                @endif

                @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
                  <td>{{ $doc->locality ?? '-' }}</td>
                @endif

                @if (is_null(request('isTrue')) || request('isTrue') == 'all' || request('isTrue') == 'no' )

                  <td>{{ $doc->status ?? '-' }}</td>
				        <td>{{ number_format($doc->budget ?? 0) }}</td>
                @php
                   $totalBudget += $doc->budget
                @endphp
                <td>{{ number_format($doc->budget_from_org ?? 0) }}</td>
                 @php
                   $totalBudgetFromOrg += $doc->budget_from_org
                @endphp
                <td>{{ number_format( $doc->budget_out_of_org ?? 0) }}</td>
                @php
                   $totalBudgetOutOfOrg += $doc->budget_out_of_org
                @endphp
                <td>{{ number_format( $doc->budget_out_of_org + $doc->budget_from_org) }}</td>
                @php
                   $totalMoney += $doc->budget_out_of_org + $doc->budget_from_org
                @endphp
                <td>{{ !empty($doc->created_at) ? date('Y-m-d', strtotime($doc->created_at)) : '--'  }}</td>

                @endif
              </tr>
            @empty
			      <tr><td colspan="14">لا توجد سير </td></tr>
			      @endforelse

            <caption class="text-primary">

              توثيق سير الشهداء
              
                @if(request()->query('name') != '')
                معسكر  {{ request()->query('name') }}
                @endif
                

                 @if (request()->query('status'))
                    @if(request()->query('status') == 'منفذ' || request()->query('isTrue') == 'yes') سير موثقة  @endif
                @endif

               @if(request()->query('sector') == 'all')
               كل القطاعات
              @else
                {{ request()->query('sector') }}
              @endif

              @if(request()->query('locality') == 'all')
               كل المحليات
              @else
                {{ request()->query('locality') }}
              @endif


              </caption>

          </x-slot:body>
        </x-table>

        {{ $martyr_docs->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}
		
        
        <hr>

        <div class="d-flex align-items-center justify-content-between  py-4 mb-5">
            <h5>
              العدد الكلي :
              <span><b>{{ number_format($martyr_docs->total()) }}</b></span>
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
      </div>
    </div>

  @include('components.footer')