@include('components.header', ['page_title' => "المعسكرات التربوية"])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')

        @php
          $totalBudget = 0;
          $totalBudgetFromOrg = 0;
          $totalBudgetOutOfOrg = 0;
          $totalMoney = 0;
        @endphp
      
      <div class="container-fluid mt-4">

        <x-alert/>


        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style">
            <li class="breadcrumb-item">
              <a href="{{ route('home') }}">الرئيسية</a>
            /

            </li>
            <li  class="mr-1 breadcrumb-item active">المعسكرات التربوية</li>
          </ol>
        </nav>
        <hr>

        <div class="d-flex justify-content-between align-items-center px-3">
          <h4> المعسكرات التربوية</h4>
          <div class="d-flex justify-content-between align-items-center ">
            <a class="btn btn-primary active" href="{{ route('tazkiia.camps.create') }}">اضافة معسكر جديد</a>

             @if (request()->query('show') != 'true')
              <a class="btn btn-success active mr-2" href="{{ request()->url() . '?show=true' }}" >
                <i class="bi bi-menu-app ml-2"></i>
                عرض كل المعسكرات
              </a>
            @else
              <a class="btn btn-info active  mr-2" href="{{ request()->url() . '?show=false' }}" >
                <i class="bi bi-x ml-2"></i>
                إخفاء كل المعسكرات
              </a>
            @endif

            @if(request()->query('show') == 'true')

              
              @if (request()->query('hiddenNotesAndActions') == 'true')
                <a class="btn btn-success active  mr-2" href="{{ request()->fullUrl() . '&hiddenNotesAndActions=false' }}" >
                  <i class="bi bi-x ml-2"></i>
                  عرض الملاحظات و العمليات
                </a>
              @else
                <a class=" mr-2 btn btn-info active " href="{{ request()->fullUrl() . '&hiddenNotesAndActions=true' }}" >
                  <i class="bi bi-x ml-2"></i>
                    إخفاء الملاحظات و العمليات
                </a>
              @endif

            @endif

            <button class="mx-4 btn  btn-primary active" onclick="printContainer()">
              <i class="bi bi-printer ml-2"></i>
                طباعة 
            </button>
          </div>
        </div>
       <hr>

       <x-date-search-form>
        <x-slot:inputs>
            <div class="col-4">
                <label>اسم المعسكر:</label>
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

        </x-slot:inputs>
       </x-date-search-form>

      @if(request('show') == 'true')
      
      <div id="printArea">
        <x-table>
          <x-slot:head>
            <th>اسم المعسكر</th>
              <th>تاريخ البداية</th>
              <th>تاريخ النهاية</th>
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
			     @forelse($camps as $camp)
              <tr>
                <td>{{ $camp->name }}</td>
                
                <td>{{ $camp->start_at }}</td>
                <td>{{ $camp->end_at }}</td>

                @if (request()->query('status') == 'all'|| is_null(request()->query('status')) )
                  <td>{{ $camp->status }}</td>
                @endif

				        <td>{{ number_format($camp->budget ?? 0) }}</td>
                <td>{{ number_format($camp->budget_from_org ?? 0) }}</td>
                <td>{{ number_format( $camp->budget_out_of_org ?? 0) }}</td>

                @php($totalBudget += $camp->budget )
                @php($totalBudgetFromOrg += $camp->budget_from_org )
                @php($totalBudgetOutOfOrg += $camp->budget_out_of_org )
                @php($totalMoney += $camp->budget_from_org + $camp->budget_out_of_org )

                 @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
                    <td>{{ $camp->sector ?? '-' }}</td>
                @endif
                @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
                <td>{{ $camp->locality ?? '-' }}</td>
                @endif
                

                 @if(request()->query('hiddenNotesAndActions') == 'true')
                  {{ '' }}
                @else
			            <td>{{ $camp->notes }}</td>
                  <td>
                    <a href="{{ route('tazkiia.camps.edit', $camp->id)}}" class="btn btn-success p-2 fs-sm">
                      <i class="bi bi-pen" title="تعديل"></i>
                    </a>
                    <a href="{{ route('tazkiia.camps.delete', $camp->id)}}" class="btn btn-danger p-2 fs-sm">
                      <i class="bi bi-trash-fill" title="حذف"></i>
                    </a>
                  </td>
              @endif
              </tr>
            @empty
			        <tr><td colspan="11">لا توجد معسكرات تربوية </td></tr>
			      @endforelse

            <caption class="text-primary">
              المعسكرات التربوية
              
                @if(request()->query('name') != '')
                معسكر  {{ request()->query('name') }}
                @endif
                

                 @if (!is_null(request()->query('status')) && request()->query('status') != 'all')

                     معسكرات {{ ' ' . request()->query('status') != 'all' ? request()->query('status'). 'ة' : '' }} 

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

              </caption>
          </x-slot:body>
        </x-table>

        {{ $camps->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}
  
         <hr>

          <div class="d-flex align-items-center px-5 justify-content-between  py-4 mb-5">
              <h5>
                العدد الكلي :
                <span><b>{{ number_format($camps->total()) }}</b></span>
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
              <h3>ادخل  اسم المعسكر في حقل البحث لعرضه, او اضغط على عرض الكل لعرض كل  المعسكرات</h3>
            </div>

          @endif

        </div>
      </div>
    </div>

  @include('components.footer')