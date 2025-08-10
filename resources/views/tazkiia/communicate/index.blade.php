@include('components.header', ['page_title' => "تواصل مع اسر الشهداء"])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">

        <x-alert/>


        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style">
            <li class="breadcrumb-item">
              <a href="{{ route('tazkiia.index') }}">التزكية الروحية </a>
              /
            </li>
            <li  class="mr-1 breadcrumb-item active">تواصل مع اسر الشهداء</li>
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
          <h4> تواصل مع اسر الشهداء </h4>
          <div class="d-flex justify-content-between align-items-center px-3">
             <button class="mx-4 btn btn-primary active" onclick="printContainer()">
                <i class="bi bi-printer ml-2"></i>
                طباعة 
              </button>
          </div>
        </div>
       <hr>

      <div class="search-form">

          <form action="{{ URL::current() }}" method="GET">

            <div class="row px-1 mt-4">

              <div class="col-2">
              <label>بحث باستخدام: </label>
                  <div class="form-group">
                  <select class="form-select" name="search">
                    <option value="all">-</option>
                    <option value="martyr_name"  @selected(request('search') == 'martyr_name')>اسم الشهيد</option>
                    <option value="militarism_number" @selected(request('search') == 'militarism_number')>النمرة العسكرية</option>
                    <option value="phone"  @selected(request('search') == 'phone')>رقم الهاتف</option>
                  </select>
                </div>
              </div>

               <div class="col-2">
                <label>حقل البحث: </label>
                <div class="form-group">
                  <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
                </div>
              </div>

               <div class="col-1">
                <label>النوع :</label>
                <div class="form-group">
                    <select name="status" class="form-select">
                      <option value="all">الكل</option>
                      <option value="مطلوب"  @selected(request('status') == 'مطلوب')>مطلوب</option>
                      <option value="منفذ" @selected(request('status') == 'منفذ')>منفذ</option>
                    </select>
                  </div>
              </div>

              <div class="col-2">
              <label>القوة: </label>
                  <div class="form-group">
                  <select class="form-select" name="force">
                    <option value="all">الكل</option>
                    @foreach(['جهاز الأمن','شرطة موحدة','قوات مسلحة','قرارات','شهداء الكرامة'] as $force)
                      <option value="{{ $force }}" @selected(request('force') == $force)>{{ $force }}</option>
                    @endforeach
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

               <!--  <div class="col-1">
                    <label>السنة: </label>
                    <div class="form-group">
                      <input type="number" class="py-4 form-control" max="2100" min="1900" step="1" name="year" placeholder="{{ request('year') }}" />
                    </div>
                  </div>

                <div class="col-1">
                    <label>الشهر: </label>
                    <div class="form-group">
                      <input type="number" class="py-4 form-control" min="1" max="12" step="1" name="month" placeholder="{{ request('month') }}" />
                    </div>
                  </div>
 -->
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


      <div id="printArea">
        <x-table>
          <x-slot:head>
            <th> اسرة الشهيد </th>
            @if (request()->query('force') == 'all' || is_null(request()->query('force')))
              <th>القوة</th>
            @endif
            <th>رقم الهاتف</th>
            <th>اتمام التواصل</th>
            <th>الحالة</th>
            <th>التقديري</th>
            <th>من  داخل المنظمة</th>
            <th>من  خارج المنظمة</th>
          </x-slot:head>

        <x-slot:body>

         @if($coms->isNotEmpty())
			      @foreach($coms as $communicate)
              <tr>
               <td>{{ $communicate->martyr_name }}</td>
               @if (request()->query('force') == 'all' || is_null(request()->query('force')))
                  <td>{{ $communicate->force }}</td>
               @endif
               <td>{{ $communicate->phone }}</td>
               <td>{{ $communicate->isCom }}</td>
               <td>{{ $communicate->status }}</td>
               <td>{{ number_format($communicate->budget) }}</td>   
               @php($totalBudget += $communicate->budget)             

               <td>{{ number_format($communicate->budget_from_org) }}</td>
               @php($totalBudgetFromOrg += $communicate->budget_from_org)

               <td>{{ number_format($communicate->budget_out_of_org) }}</td>
               @php($totalBudgetFromOrg += $communicate->budget_from_org)
               @php($totalMoney += $communicate->budget_from_org + $communicate->budget_out_of_org)

            </tr>
			     @endforeach
            @else
              <tr>
                <td colspan="9">لا توجد نتائج</td>
              </tr>
            @endif  
			


           <caption>
              تواصل مع اسر الشهداء

              @if(!is_null(request()->query('force')) && request()->query('force') != 'all')
                {{ request()->query('force') }}
              @endif


              @if (request()->query('search') == 'martyr_name')
                - اسر الشهيد {{ request()->query('needel') }}
              @endif

               @if(request()->query('sector') == 'all' || is_null(request()->query('sector')))
               كل القطاعات
              @else
                {{ request()->query('sector') }}
              @endif

              @if(request()->query('locality') == 'all')
               كل المحليات
              @else
                {{ request()->query('locality') }}
              @endif

               @empty(!request()->query('year'))
                {{ 'سنة ' . request()->query('year')  . (request()->query('month') != '' ?  ' شهر ' . request()->query('month') : ' لكل الشهور     ')}}
                @endempty

           </caption>


        </x-slot:body>

        

      </x-table>


        {{ $coms->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}


        
        <hr>

        <div class="d-flex align-items-center px-5 justify-content-between  py-4 mb-5">
            <h5>
              العدد الكلي :
              <span><b>{{ number_format($coms->total()) }}</b></span>
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
    </div>

  @include('components.footer')