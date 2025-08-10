@include('components.header', ['page_title' => 'الكفالات الشهرية'])

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
             الكفالات الشهرية
            </li>
          </ol>
        </nav>

        <hr>

      <div class="d-flex justify-content-between align-items-center px-3">
        <h4>الكفالات الشهرية</h4>
        <div class="d-flex justify-content-between">
         @if (request()->query('show') != 'true')
              <a class="btn btn-success active" href="{{ request()->url() . '?show=true' }}" >
                <i class="bi bi-menu-app ml-2"></i>
                عرض كل الكفالات
              </a>
            @else
              <a class="btn btn-info active" href="{{ request()->url() . '?show=false' }}" >
                <i class="bi bi-x ml-2"></i>
                إخفاء كل الكفالات
              </a>
            @endif


            <button class="mx-4 btn  btn-primary active" onclick="printContainer()">
              <i class="bi bi-printer ml-2"></i>
                طباعة 
            </button>
          </div>
      </div>

      <hr>
      
        @php
          $totalBudget = 0;
          $totalBudgetFromOrg = 0;
          $totalBudgetOutOfOrg = 0;
          $totalMoney = 0;
        @endphp

      <x-date-search-form>

        <x-slot:inputs>

          <input type="hidden" name="show" value="true">


            <div class="col-1">
                <label>بحث باستخدام :</label>
                <div class="form-group">
                    <select name="search" class="form-select">
                      <option value="all"> --- </option>
                      <option value="martyr_name" @selected(request('search') == 'martyr_name')>اسم الشهيد</option>
                      <option value="force" @selected(request('search') == 'force')>قوة الشهيد</option>
                      <option value="category" @selected(request('search') == 'category')>شريحة الاسرة</option>
                    </select>
                  </div>
              </div>


              <div class="col-1">
                <label>بحث عن: </label>
                <div class="form-group">
                  <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
                </div>
              </div>
              
              

            <div class="col-1">
                <label>نوع  الكفالة :</label>
                <div class="form-group">
                  <select name="type" class="form-select">
                     <option value="all" @selected(request('type') == 'all')>الكل</option>
                     <option value="مجتمعية" @selected(request('type') == 'مجتمعية' )>مجتمعية</option>
                     <option value="مؤسسية" @selected(request('type') == 'مؤسسية' )>مؤسسية</option>
                     <option value="المنظمة" @selected(request('type') == 'المنظمة' )>المنظمة</option>
                  </select>
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
              <div class="form-group">
                <label>المتكفل :</label>
                <select name="provider" class="form-select">
                    <option value="all" @selected(request('provider') == 'all')>الكل</option>
                    <option value="الحكومة"  @selected(request('provider') == 'الحكومة')>الحكومة</option>
                    <option value="ديوان الزكاة"  @selected(request('provider') == 'ديوان الزكاة')>ديوان الزكاة</option>
                    <option value="دعم شعبي"  @selected(request('provider') == 'عم شعبي')>دعم شعبي</option>
                    <option value="ايرادات المنظمة"  @selected(request('provider') == 'يرادات المنظمة')>ايرادات المنظمة</option>
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

        </x-slot:inputs>

      </x-date-search-form>

      @if (request()->query('show') == 'true')
      <div id="printArea">
        <x-table>
          <x-slot:head>
            @if (request()->query('search') !== 'martyr_name')
              <th>اسرة الشهيد</th>
            @endif
            @if (request()->query('search') !== 'category')
              <th>الشريحة</th>
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
            <th>نوع الكفالة</th>
            @endif
            @if (request()->query('provider') == 'all'|| is_null(request()->query('provider')) )
              <th>المتكفل</th>
            @endif
            @if (empty(request()->query('month')) || is_null(request()->query('month')) )
              <th>الشهر</th>
            @endif
            @if (empty(request()->query('year')) || is_null(request()->query('year')) )
              <th>السنة</th>
            @endif
            @if (request()->query('status') == 'all'|| is_null(request()->query('status')) )
              <th>الحالة</th>
            @endif
            <th>التقديري</th>
            <th>من داخل المنظمة</th>
            <th>من خارج المنظمة</th>
            <th>المبلغ المؤمن</th>
            {{-- <th>عمليات</th> --}}
          </x-slot:head>

          <x-slot:body>
            @forelse ($bails as $bail)
            <tr>
              @if (request()->query('search') !== 'martyr_name')
              <td>{{ @$bail->martyr_name }}</td>
              @endif
              @if (request()->query('search') !== 'category')
                <td>{{ $bail->category }}</td>
              @endif
               @if (request()->query('search') !== 'force')
                <td>{{ $bail->force }}</td>
                @endif

                @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
                  <td>{{ $bail->sector }}</td> 
                @endif

                @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
                  <td>{{ $bail->locality }}</td>
                @endif
                

                @if (request()->query('type') == 'all'|| is_null(request()->query('type')) )
                  <td>{{ $bail->type  }}</td>
                @endif

                @if (request()->query('provider') == 'all'|| is_null(request()->query('provider')) )
                  <td>{{ @$bail->provider }}</td>

                @endif

                @if (empty(request()->query('month')) || is_null(request()->query('month')) )
                  <td>{{ date('m', strtotime($bail->created_at)) }}</td>
                @endif
                @if (empty(request()->query('year')) || is_null(request()->query('year')) )
                  <td>{{ date('Y', strtotime($bail->created_at)) }}</td>
                @endif                
                
                @if (request()->query('status') == 'all'|| is_null(request()->query('status')) )
                   <td>{{ @$bail->status }}</td>
                @endif

                <td>{{ number_format($bail->budget) }}</td>
                @php($totalBudget += $bail->budget)

                <td>{{ number_format($bail->budget_from_org) }}</td>
                @php($totalBudgetFromOrg += $bail->budget_from_org)

                <td>{{ number_format($bail->budget_out_of_org) }}</td>
                @php($totalBudgetOutOfOrg += $bail->budget_out_of_org)

                <td>{{ number_format($bail->budget_from_org + $bail->budget_out_of_org) }}</td>
                @php($totalMoney += $bail->budget_from_org + $bail->budget_out_of_org )
                
                
                {{-- <td>
                  <a href="{{ route('bails.edit', $bail->bail_id) }}" class="btn btn-success p-2 fa-sm">
                    <i class="bi bi-pen" title="تعديل"></i>
                  </a>
                  <a href="{{ route('bails.delete', $bail->bail_id) }}" class="btn btn-danger p-2 fa-sm">
                    <i class="bi bi-trash-fill" title="حذف"></i>
                  </a>
                  </td> --}}
              </tr>
            @empty
              <tr><td colspan="15">لا توجد نتائج</td></tr>
            @endforelse

            <caption class="text-primary">
الكفالات الشهرية 
                @if(request()->query('search') == 'category')
                  شريحة {{ request()->query('needel') }}
                @endif
                
                @if(request()->query('search') == 'martyr_name')
                اسرة الشهيد {{ request()->query('needel') }}
                @endif

                 @if(request()->query('search') == 'force')
                 {{ request()->query('needel') }}
                @endif
                
                
                @if(!is_null(request()->query('type')) && request()->query('type') != 'all')

                  كفالات {{  request()->query('type') }} 
                    @if (!is_null(request()->query('status')) && request()->query('status') != 'all')

                    {{ ' ' . request()->query('status') != 'all' ? request()->query('status'). 'ة' : '' }} 

                  @endif
                @endif

                 
                @if(!is_null(request()->query('provider')) && request()->query('provider') != 'all')
                 المتكفل {{ request()->query('provider') }}
                @endif
                
                @if (request()->query('type') == 'all' && !is_null(request()->query('status')) && request()->query('status') != 'all')

                  كفالات {{ ' ' . request()->query('status') != 'all' ? request()->query('status'). 'ة' : '' }} 

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

      {{ $bails->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}
      

        <hr>

        <div class="d-flex align-items-center px-5 justify-content-between  py-4 mb-5">
            <h5>
              العدد الكلي :
              <span><b>{{ number_format($bails->total()) }}</b></span>
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
            <h3>ادخل  اسم الشهيد في حقل البحث لعرضه, او اضغط على عرض الكل لعرض كل الكفالات لكل الاسر</h3>
        </div>

      @endif

      </div>

    </div>

  @include('components.footer')