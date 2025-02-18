@include('components.header', ['page_title' => "ندوات و محاضرات"])

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
            <li  class="mr-1 breadcrumb-item active">الندوات و المحاضرات </li>
          </ol>
        </nav>

      <hr>


        <div class="d-flex justify-content-between align-items-center px-3">
          <h4> ندوات و محاضرات </h4>
        
        <div class="d-flex justify-content-between align-items-center ">
          <a class="btn btn-primary active" href="{{ route('tazkiia.lectures.create') }}">اضافة محاضرة جديدة</a>

             @if (request()->query('show') != 'true')
              <a class="btn btn-success active mr-2" href="{{ request()->url() . '?show=true' }}" >
                <i class="bi bi-menu-app ml-2"></i>
                عرض كل  المحاضرات
              </a>
            @else
              <a class="btn btn-info active  mr-2" href="{{ request()->url() . '?show=false' }}" >
                <i class="bi bi-x ml-2"></i>
                إخفاء كل  المحاضرات
              </a>
            @endif

            @if(request()->query('show') == 'true')

              
              @if (request()->query('hiddenNotesAndActions') == 'true')
                <a class="btn btn-success active  mr-2" href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'false']) }}" >
                  <i class="bi bi-x ml-2"></i>
                  عرض الملاحظات و العمليات
                </a>
              @else
                <a class=" mr-2 btn btn-info active " href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'true']) }}" >
                  <i class="bi bi-x ml-2"></i>
                    إخفاء الملاحظات و العمليات
                </a>
              @endif

            @endif

          </div>
        </div>
       <hr>


      <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">
            
              <input type="hidden" name="hiddenNotesAndActions" value="false">
              <input type="hidden" name="show" value="ture">
            <div class="row px-1 mt-4">

              <div class="col-4">

                <label>اسم الندوة او المحاضرة :</label>
                <div class="form-group">
                  <input type="text" name="name" class="form-control py-4" value="{{ request('name') }}"/>
                </div>
            </div>
            <div class="col-1">
                <label>حالة الخدمة :</label>
                <div class="form-group">
                  <select name="status" class="form-select">
                     <option value="all" @selected(request('status') == 'all')>الكل</option>
                     <option value="مطلوب" @selected(request('status') == 'مطلوب' )>مطلوب</option>
                     <option value="منفذ" @selected(request('status') == 'منفذ' )>منفذ</option>
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

              <input name="show" value="true" type="hidden">
              <input name="hiddenNotesAndActions" value="true" type="hidden">

              <div class="col-2">
                <label>تاريخ  المحاضرة : </label>
                <div class="form-group">
                  <input type="date" name="date" value="{{ request()->query('date') }}" class="form-control py-4" />
                </div>
              </div>

              <div class="col-1 mt-3 d-flex align-items-center justify-content-center">
                <button class="btn py-4 btn-primary active form-control ml-1" title="بحث ">
                  <i class="bi bi-search ml-2"></i>
                </button>
                <a class="btn py-4 btn-success active form-control " title="الغاء الفلاتر" href="{{ request()->url() . '?show=false' }}">
                  <i class="bi bi-menu-button ml-2"></i>
                </a>
              </div>

            </form>

            </div>
        </div>
         <div class="d-flex justify-content-between align-items-center px-3" style="width: fit-content">
                <button class="mx-4 btn py-4 btn-primary active form-control" onclick="printContainer()">
                <i class="bi bi-printer ml-2"></i>
                  طباعة 
                </button>
              </div>


        @php
          $totalBudget = 0;
          $totalBudgetFromOrg = 0;
          $totalBudgetOutOfOrg = 0;
          $totalMoney = 0;
        @endphp



      @if(request('show') == 'true')

      <div id="printArea">
        <x-table>
          <x-slot:head>
			        <th>#</th>
              <th>اسم المحاضرة</th>
              <th>تاريخ المحاضرة</th>
              <th>الحالة</th>
              <th>التقديري</th>
              <th>من داخل المنظمة</th>
              <th>من خارج المنظمة </th>
                 @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
                  <th>القطاع</th>
                  @endif
                @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
                  <th>المحلية</th>
                @endif

              @if(request()->query('hiddenNotesAndActions') == 'false')
			         <th>ملاحظات</th>
			         <th>عمليات</th>
              @endif
          </x-slot:head>

        <x-slot:body>
		      @if($lectures->isNotEmpty())
			     @foreach($lectures as $lecture)
              <tr>
			          <td>{{ $lecture->id }}</td>
                <td>{{ $lecture->name }}</td>
                <td>{{ $lecture->date }}</td>
                <td>{{ $lecture->status }}</td>
				        <td>{{ number_format($lecture->budget ?? 0) }}</td>
                @php($totalBudget += $lecture->budget)

                <td>{{ number_format($lecture->budget_from_org ?? 0) }}</td>
                @php($totalBudgetFromOrg += $lecture->budget_from_org)

                <td>{{ number_format( $lecture->budget_out_of_org ?? 0) }}</td>

                @php($totalBudgetOutOfOrg += $lecture->budget_out_of_org)
                @php($totalMoney += $lecture->budget_out_of_org + $lecture->budget_from_org)


                @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
                    <td>{{ $lecture->sector ?? '-' }}</td>
                @endif
                @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
                <td>{{ $lecture->locality ?? '-' }}</td>
                @endif
                

                @if(request()->query('hiddenNotesAndActions') == 'false')
                  <td>{{ $lecture->notes }}</td>
                  <td>
                    <a href="{{ route('tazkiia.lectures.edit', $lecture->id)}}" class="btn btn-success p-2 fs-sm">
                      <i class="bi bi-pen" title="تعديل"></i>
                    </a>
                    <a href="{{ route('tazkiia.lectures.delete', $lecture->id)}}" class="btn btn-danger p-2 fs-sm">
                      <i class="bi bi-trash-fill" title="حذف"></i>
                    </a>
                  </td>
                </tr>
                @endif

			      @endforeach
		        @else
			        <tr><td colspan="9">لا توجد ندوات و محاضرات </td></tr>
        		@endif

          <caption class="text-primary">
              ندوات و محاضرات 


              @if(request()->query('name') != '')
              محاضرة   {{ request()->query('name') }}
              @endif

              @if(request()->query('date') != '')
                بتاريخ  {{ request()->query('date') }}
              @endif


                

                 @if (!is_null(request()->query('status')) && request()->query('status') != 'all')

                     ندوات و محاضرات {{ ' ' . request()->query('status') != 'all' ? request()->query('status'). 'ة' : '' }} 

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


              </caption>

          </x-slot:body>
        </x-table>

        {{ $lectures->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}
		

        @else    

          <div class="text-center p-5 mx-auto my-5">
              <h3>ادخل  اسم  الندوة او المحاضرة في حقل البحث لعرضها, او اضغط على عرض الكل لعرض كل  المحاضرات </h3>
          </div>

        @endif

        
          <hr>

          <div class="d-flex align-items-center justify-content-between py-4 mb-5">
             <h5>
                العدد الكلي :
                <span><b>{{ number_format($lectures->total()) }}</b></span>
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
          {{-- printArea end --}}
      </div> 



        </div>
      </div>
    </div>

  @include('components.footer')