@include('components.header', ['page_title' => ' العلاج الطبي'])

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
             العلاج الطبي
            </li>
          </ol>
        </nav>

        <hr>


        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>العلاج الطبي</h4>

          <div class="d-flex justify-content-between align-items-center">

          @if (request()->query('show') != 'true')
              <a class="btn btn-success active" href="{{ request()->url() . '?show=true' }}" >
                <i class="bi bi-menu-app ml-2"></i>
                عرض كل الخدمات
              </a>
            @else
              <a class="btn btn-info active" href="{{ request()->url() . '?show=false' }}" >
                <i class="bi bi-x ml-2"></i>
                إخفاء كل الخدمات
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

        <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row px-1 mt-4">
  
              <div class="col-2">
                <label>بحث باستخدام :</label>
                <div class="form-group">
                    <select name="search" class="form-select">
                      <option value="all"> --- </option>
                      <option value="name" @selected(request('search') == 'name')>اسم المستفيد</option>
                      <option value="martyr_name" @selected(request('search') == 'martyr_name')>اسم الشهيد</option>
                      <option value="force" @selected(request('search') == 'force')>قوة الشهيد</option>
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
                <label>النوع :</label>
                <div class="form-group">
                    <select name="gender" class="form-select">
                      <option value="all"  @selected(request('gender') == "all")>الكل</option>
                      <option value="ذكر"  @selected(request('gender') == "ذكر")>ذكر</option>
                      <option value="أنثى"  @selected(request('gender') == "أنثى")>أنثى</option>
                    </select>
                  </div>
              </div>

              <div class="col-1">
                <label>العلاقة :</label>
                <div class="form-group">
                  <select name="relation" class="form-select">
                    <option value="all"  @selected(request('relation') == "all")>الكل</option>
                    <option value="ابن" @selected(request('relation') == 'ابن')>ابن</option>
                    <option value="ابنة" @selected(request('relation') == 'ابنة')>ابنة</option>
                    <option value="اخ" @selected(request('relation') == 'اخ')>اخ</option>
                    <option value="اخت" @selected(request('relation') == 'اخت')>اخت</option>
                    <option value="اب" @selected(request('relation') == 'اب')>اب</option>
                    <option value="ام" @selected(request('relation') == 'ام')>ام</option>
                    <option value="زوجة" @selected(request('relation') == 'زوجة')>زوجة</option>
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
                <label> نوع الخدمة :</label>
                <div class="form-group">
                    <select name="type" class="form-select">
                      <option value="all">الكل</option>
                      <option value="التأمين الصحي"  @selected(request('type') == 'التأمين الصحي')>التأمين الصحي</option>
                      <option value="علاج خارج المظلة" @selected(request('type') == 'علاج خارج المظلة')>علاج خارج المظلة</option>
                      <option value="علاج بالخارج" @selected(request('type') == 'علاج بالخارج')>علاج بالخارج</option>
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
                    <input type="number" class="py-4 form-control" max="2100" min="1900" step="1" name="year" value="{{ request('year')  }}" />
                  </div>
                </div>

              <div class="col-1">
                  <label>الشهر: </label>
                  <div class="form-group">
                    <input type="number" class="py-4 form-control" min="1" max="12" step="1" name="month" value="{{ request('month')  }}" />
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
        <div id="printArea">
             <x-table>
            <x-slot:head>
              @if (request()->query('search') != 'name')
                <th> اسم المستفيد </th>
              @endif
              @if (request()->query('relation') == 'all' || is_null(request()->query('relation')))
              <th>العلاقة</th>
              @endif

              @if (request()->query('search') !== 'martyr_name')
                <th>اسرة الشهيد</th>
              @endif
              @if (request()->query('search') !== 'force')
                  <th>قوة الشهيد</th>
                @endif
              <th>رقم التأمين</th>
              @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
              <th>القطاع</th>
              @endif
              @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
                <th>المحلية</th>
              @endif
              @if (request()->query('type') == 'all'|| is_null(request()->query('type')) )
                <th>نوع الخدمة</th>
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
             @forelse($medicalTreatments as $medicalTreatment)
              <tr>
                @if (request()->query('search') != 'name')
                  <td>{{ $medicalTreatment->name }}</td>
                @endif

                @if (request()->query('relation') == 'all' || is_null(request()->query('relation')))
                  <td>{{ $medicalTreatment->relation }}</td>
                @endif

                @if (request()->query('search') !== 'martyr_name')
                  <td>{{ $medicalTreatment->martyr_name }}</td>
                @endif
                @if (request()->query('search') !== 'force')
                  <td>{{ $medicalTreatment->force }}</td>
                @endif
                <td>{{ $medicalTreatment->health_insurance_number ?? 'لا يوجد' }}</td>

                @if (request()->query('sector') !=  $medicalTreatment->sector)
                  <td>
                    {{ $medicalTreatment->sector ?? '-'}}
                  </td>
                @endif

                @if ( request()->query('locality') !=  $medicalTreatment->locality)
                  <td>
                      {{ $medicalTreatment->locality ?? '-'}}
                    </td>
                @endif

                
                @if (request()->query('type') == 'all'|| is_null(request()->query('type')) )
                  <td>{{ $medicalTreatment->type }}</td>
                @endif

                @if (request()->query('status') == 'all'|| is_null(request()->query('status')) )
                  <td>{{ $medicalTreatment->status }}</td>
                @endif

                <td>{{ number_format($medicalTreatment->budget) }}</td>
                @php($totalBudget += $medicalTreatment->budget)
                
                <td>{{ number_format($medicalTreatment->budget_from_org) ?? '-' }}</td>
                @php($totalBudgetFromOrg += $medicalTreatment->budget_from_org)
                
                <td>{{ number_format($medicalTreatment->budget_out_of_org ) ?? '-' }}</td>
                @php($totalBudgetOutOfOrg += $medicalTreatment->budget_out_of_org)
                
                <td>{{ number_format($medicalTreatment->budget_from_org + $medicalTreatment->budget_out_of_org ) ?? '-' }}</td>
                @php($totalMoney += $medicalTreatment->budget_from_org + $medicalTreatment->budget_out_of_org)
                
                <td>{{ date('Y-m-d', strtotime($medicalTreatment->created_at)) }}</td>
                {{-- <td>
                  <a href="{{ route('medicalTreatment.edit', $medicalTreatment->medicalTreatment_id) }}" class="btn btn-success p-2 fa-sm">
                    <i class="bi bi-pen" title="تعديل"></i>
                  </a>
                  <a href="{{ route('medicalTreatment.delete', $medicalTreatment->medicalTreatment_id) }}" class="btn btn-danger p-2 fa-sm">
                    <i class="bi bi-trash-fill" title="حذف"></i>
                  </a>
                  </td> --}}
                </tr>
              @empty
			          <tr>
				           <td colspan="16">لا توجد نتائج</td>
			          </tr>
              @endforelse

            <caption class="text-primary">

              العلاج الطبي 
               @if(request()->query('search') == 'name')
                {{ request()->query('needel') }} 
                @endif

               @if(request()->query('search') == 'martyr_name')
                اسرة الشهيد {{ request()->query('needel') }}
                @endif

               @if(request()->query('search') == 'force')
                افراد اسر {{ request()->query('needel') }}
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

              @if(request()->query('sector') != 'all')
                {{ request()->query('sector') }}

                @else
                  كل القطاعات
                @endif

                @if( request()->query('locality') == 'all') 
                  كل المحليات
                @else

                {{ ' - ' . request()->query('locality')  }}

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
          {{ $medicalTreatments->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}
          
          <hr>

          <div class="d-flex align-items-center justify-content-between  py-4 mb-5">
            <h5>
                العدد الكلي :
                <span><b>{{ number_format($medicalTreatments->total()) }}</b></span>
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
              <h3>ادخل  اسم المستفيد او الشهيد في حقل البحث لعرضه, او اضغط على عرض الكل لعرض كل الخدمات المقدمة لكل الاسر</h3>
            </div>
          
          @endif
 
         
          

        </div>

    </div>
  @include('components.footer')