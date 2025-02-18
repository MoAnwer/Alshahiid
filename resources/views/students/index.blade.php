@include('components.header', ['page_title' => "الطلاب"])

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
              <a href="{{ route('home') }}">الرئيسية</a>
              /
            </li>
            <li  class="breadcrumb-item active">الطلاب</li>
          </ol>
        </nav>
        
        <hr>
        
      </div>

      <div class="container-fluid mt-4">

        <div class="d-flex justify-content-between align-items-center pl-3">
          <h3>الطلاب</h3>
          <div class="d-flex justify-content-between align-items-center ">
              @if (request()->query('show') != 'true')
              <a class="btn btn-success active" href="{{ request()->url() . '?show=true' }}" >
                <i class="bi bi-menu-app ml-2"></i>
                عرض كل الطلاب
              </a>
            @else
              <a class="btn btn-info active" href="{{ request()->url() . '?show=false' }}" >
                <i class="bi bi-x ml-2"></i>
                إخفاء الكل
              </a>
            @endif
            <button class="mx-4 btn  btn-primary active" onclick="printContainer()">
              <i class="bi bi-printer ml-2"></i>
                طباعة 
            </button>
             
          </div>
           
        </div>
        <hr>



          <div class="search-form mx-3 mt-3">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row">

              <input type="hidden" name="show" value="true">
              
              <div class="col-2">
                <label>بحث باستخدام :</label>
                <div class="form-group">
                    <select name="search" class="form-select">
                      <option value="">--- </option>
                      <option value="name" @selected(request('search') == 'name')>اسم </option>
                      <option value="martyr_name" @selected(request('search') == 'martyr_name')>اسم  الشهيد</option>
                      <option value="militarism_number" @selected(request('search') == 'militarism_number')>النمرة العسكرية</option>
                      <option value="force" @selected(request('search') == 'force')>القوة  الشهيد</option>
                      <option value="school_name" @selected(request('search') == 'school_name')>المدرسة</option>
                      <option value="class" @selected(request('search') == 'class')>الصف</option>
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
              
               <div class="col-2">
                <label>المرحلة :</label>
                <div class="form-group">
                    <select name="stage" class="form-select">
                      <option value="all">كل المراحل</option>
                      <option value="الإبتدائي" @selected(request('stage') == 'الإبتدائي')>الإبتدائي</option>
                      <option value="المتوسط" @selected(request('stage') == 'المتوسط')>المتوسط</option>
                      <option value="الثانوي"  @selected(request('stage') == 'الثانوي')>الثانوي</option>
                      <option value="جامعي"  @selected(request('stage') == 'جامعي')>جامعي</option>
                      <option value="فوق الجامعي"  @selected(request('stage') == 'فوق الجامعي')>فوق الجامعي</option>
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

              
              <div class="col-1 mt-3 d-flex align-items-center">
                <button class="btn py-3 px-2 btn-primary active form-control ml-2" title="بحث">
                  <i class="bi bi-search"></i>
                </button>
                <a class="btn py-3 px-2 btn-success active form-control " title="القائمة" href="{{ request()->url() }}">
                  <i class="bi bi-menu-button"></i>
                </a>
              </div>


              </form>

            </div>
          </div> {{-- search form --}}          
        
      @if (request()->query('show') == 'true' || !empty(request()->query('search')))

      <div id="printArea">
        <x-table>
          <x-slot:head>

            <th>الاسم</th>
            
            @if (request()->query('gender') == 'all' || is_null(request()->query('gender')))
            <th>النوع</th>
            @endif

            @if (request()->query('relation') == 'all' || is_null(request()->query('relation')))
            <th>العلاقة</th>
            @endif

            @if (request()->query('search') !== 'martyr_name')
              <th>الشهيد</th>
            @endif

 
            @if (request()->query('search') !== 'force')
              <th>قوة الشهيد</th>
            @endif
            
            @if (request()->query('stage') == 'all' || is_null(request()->query('stage')))
            <th>المرحلة</th>
            @endif
            @if (request()->query('search') !== 'class')
              <th>الصف</th>
            @endif

            @if (request()->query('search') !== 'school_name')
              <th>المدرسة</th>
            @endif
            
             @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
              <th>القطاع</th>
              @endif
            @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
              <th>المحلية</th>
            @endif
          </x-slot:head>

          <x-slot:body>
            @forelse ($students as $student)
              <tr>
                <td>{{ $student->name }}</td>
                 @if (request()->query('gender') == 'all' || is_null(request()->query('gender')))
                  <td>{{ $student->gender }}</td>
                @endif
                
                @if (request()->query('relation') == 'all' || is_null(request()->query('relation')))
                  <td>{{ $student->relation }}</td>
                @endif
                
                @if (request()->query('search') !== 'martyr_name')
                  <td>{{ $student->martyr_name }}</td>
                @endif

                @if (request()->query('search') !== 'force')
                  <td>{{ $student->force }}</td>
                @endif

                @if (request()->query('stage') == 'all' || is_null(request()->query('stage')))
                  <td>{{ $student->stage ?? '-' }}</td>
                @endif

                @if (request()->query('search') !== 'class')
                  <td>{{ $student->class ?? '-' }}</td>
                @endif

                @if (request()->query('search') !== 'school_name')
                  <td>{{ $student->school_name ?? '-' }}</td>
                @endif

                @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
                <td>{{ $student->sector ?? '-' }}</td>
                @endif
                @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
                <td>{{ $student->locality ?? '-' }}</td>
                @endif
              </tr>
            @empty
              <tr><td colspan="11">لا توجد نتائج</td></tr>
            @endforelse

          <caption class="text-primary">
                طلاب
                @if(request()->query('search') == 'martyr_name')
                اسرة الشهيد {{ request()->query('needel') }}
                @endif

                @if(request()->query('search') == 'force')
                   {{ request()->query('needel') }} 
                @endif


                @if(request()->query('search') == 'militarism_number')
                اسرة الشهيد  صاحب النمرة العسكرية {{ request()->query('needel') }}
                @endif


                @if(request()->query('search') == 'school_name')
                مدرسة {{ request()->query('needel') }}
                @endif
                @if(request()->query('search') == 'class')
                الصف {{ request()->query('needel') }}
                @endif

                
                @if(!is_null(request()->query('relation')) && request()->query('relation') != 'all')
                 - {{ request()->query('relation') }} - 
                @endif

                @if(!is_null(request()->query('gender')) && request()->query('gender') != 'all')
                 {{ request()->query('gender') }}
                @endif
                
                
                
                @if(!is_null(request()->query('stage')) && request()->query('stage') != 'all')

                  المرحلة {{  request()->query('stage') . 'ة' }} 
                    @if (!is_null(request()->query('search')) && request()->query('search') == 'class')

                    {{ ' ' . request()->query('search') == 'class' ? request()->query('search'). 'ة' : '' }} 

                  @endif
                @endif
                
                @if (request()->query('type') == 'all' && !is_null(request()->query('search')) && request()->query('search') == 'class')

                  المرحلة {{ ' ' . request()->query('search') == 'class' ? request()->query('search'). 'ة' : '' }} 

                @endif

             
                @if(request()->query('sector') !== 'all' && !is_null(request()->query('sector')))
                  {{ request()->query('sector') }}
                  @else 
                  {{ 'كل القطاعات' }}
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

        <hr>

        <div class="d-flex align-items-center justify-content-between  py-4 mb-5">
            <h5>
              العدد الكلي :
              <span><b>{{ number_format($students->total()) }}</b></span>
          </h5>
        </div>

        </div>

        @else

                <div class="text-center p-5 mx-auto my-5">
              <h3>ادخل  اسم المستفيد او الشهيد في حقل البحث لعرضه, او اضغط على عرض كل الطلاب</h3>
            </div>

        @endif



      {{ $students->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}

      </div>

    </div>

  @include('components.footer')