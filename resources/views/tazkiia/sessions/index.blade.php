  @include('components.header', ['page_title' => "الحلقات"])

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
              <a href="{{ route('home') }}">الرئيسية</a>
            /

            </li>
            <li  class="mr-1 breadcrumb-item active">الحلقات </li>
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
          <h4> الحلقات </h4>
          <div class="d-flex justify-content-between align-items-center ">
            <a class="btn btn-primary active" href="{{ route('tazkiia.sessions.create') }}">اضافة حلقة جديد</a>

             @if (request()->query('show') != 'true')
              <a class="btn btn-success active mr-2" href="{{ request()->url() . '?show=true' }}" >
                <i class="bi bi-menu-app ml-2"></i>
                عرض كل الحلقات
              </a>
            @else
              <a class="btn btn-info active  mr-2" href="{{ request()->url() . '?show=false' }}" >
                <i class="bi bi-x ml-2"></i>
                إخفاء كل الحلقات
              </a>
            @endif

            @if(request()->query('show') == 'true')

              
              @if (request()->query('hiddenNotesAndActions') == 'true')
                <a class="btn btn-success active mr-2" href="{{  request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'false']) }}" >
                  <i class="bi bi-x ml-2"></i>
                  عرض الملاحظات و العمليات
                </a>
              @else
                <a class=" mr-2 btn btn-info active " href=" {{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'true']) }} " >
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
          
          <div class="row px-1 mt-4">


              <div class="col-4">
                <label>اسم الحلقة:</label>
                <div class="form-group">
                  <input type="text" name="name" class="form-control py-4" value="{{ request('name') }}"/>
                </div>
            </div>
            <div class="col-1">
                <label>حالة  :</label>
                <div class="form-group">
                  <select name="status" class="form-select">
                     <option value="all" @selected(request('status') == 'all')>الكل</option>
                     <option value="مطلوب" @selected(request('status') == 'مطلوب' )>مطلوب</option>
                     <option value="منفذ" @selected(request('status') == 'منفذ' )>منفذ</option>
                  </select>
                </div>
            </div>
            
            <div class="col-2">
              <label>تاريخ  الحلقة : </label>
                <div class="form-group">
                  <input type="date" name="date" value="{{ request()->query('date') }}" class="form-control py-4" />
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

      @if(request('show') == 'true')
      <div id="printArea">
        <x-table>
          <x-slot:head>
            @if (empty(request()->query('name')) || is_null(request()->query('name')))
              <th>اسم الحلقة</th>
            @endif

             @if (request()->query('date') == 'all'|| is_null(request()->query('date')) )
                  <th>تاريخ الحلقة</th>
              @endif


              @if (request()->query('status') == 'all'|| is_null(request()->query('status')) )
                  <th>الحالة</th>
              @endif

              <th>التقديري</th>
              <th>من داخل المنظمة</th>
              <th>من خارج المنظمة </th>
			        @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
                  <th>القطاع</th>
                  @endif
                @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
                  <th>المحلية</th>
                @endif
                
              @if(request()->query('hiddenNotesAndActions') == 'true')
                  {{ '' }}
                @else
			            <th>ملاحظات</th>
                  <th>عمليات</th>
              @endif
          </x-slot:head>

        <x-slot:body>
			     @forelse($sessions as $session)
              <tr>
               @if (empty(request()->query('name')) || is_null(request()->query('name')))
                  <td>{{ $session->name }}</td>
                @endif


                @if (request()->query('date') == 'all'|| is_null(request()->query('date')) )
                  <td>{{ $session->date }}</td>
                @endif

                  @if (request()->query('status') == 'all'|| is_null(request()->query('status')) )
                  <td>{{ $session->status }}</td>
                @endif


				        <td>{{ number_format($session->budget ?? 0) }}</td>
                @php($totalBudget += $session->budget)

                <td>{{ number_format($session->budget_from_org ?? 0) }}</td>
                @php($totalBudgetFromOrg += $session->budget_from_org)

                <td>{{ number_format( $session->budget_out_of_org ?? 0) }}</td>
                @php($totalBudgetOutOfOrg += $session->budget_out_of_org)
                @php($totalMoney += $session->budget_out_of_org + $session->budget_from_org)
                  

                 @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
                    <td>{{ $session->sector ?? '-' }}</td>
                @endif
                @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
                <td>{{ $session->locality ?? '-' }}</td>
                @endif
                

                 @if(request()->query('hiddenNotesAndActions') == 'true')
                  {{ '' }}
                @else
			            <td>{{ $session->notes }}</td>
                  <td>
                    <a href="{{ route('tazkiia.sessions.edit', $session->id)}}" class="btn btn-success p-2 fs-sm">
                      <i class="bi bi-pen" title="تعديل"></i>
                    </a>
                    <a href="{{ route('tazkiia.sessions.delete', $session->id)}}" class="btn btn-danger p-2 fs-sm">
                      <i class="bi bi-trash-fill" title="حذف"></i>
                    </a>
                  </td>
              @endif
              </tr>

            @empty
            
			        <tr><td colspan="9">لا توجد حلقات </td></tr>

			      @endforelse

            <caption class="text-primary">

                @if(request()->query('name') != '')
                حلقة  {{ request()->query('name') }}
                @else 
                  حلقات
                @endif
                

                @if(request()->query('date') != '')
                بتاريخ  {{ request()->query('date') }}
                @endif



                 @if (!is_null(request()->query('status')) && request()->query('status') != 'all')

                     حلقات  {{ ' ' . request()->query('status') != 'all' ? request()->query('status'). 'ة' : '' }} 

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
                 
                @else
                  سنة {{ request()->query('year') }}
                @endif

                @if(request()->query('month') == '' && is_null(request()->query('month')))
                  
                @else
                  شهر {{ request()->query('month') }}
                @endif

          </x-slot:body>
        </x-table>

        {{ $sessions->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}
  
  

          @else    

            <div class="text-center p-5 mx-auto my-5">
              <h3>ادخل  اسم الحلقة في حقل البحث لعرضه, او اضغط على عرض الكل لعرض كل  الحلقات</h3>
            </div>

          @endif


          <hr>

          <div class="d-flex align-items-center justify-content-between py-4 mb-5">
             <h5>
                العدد الكلي :
                <span><b>{{ number_format($sessions->total()) }}</b></span>
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