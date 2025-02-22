@include('components.header', ['page_title' => 'قائمة اسر الشهداء'])

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
            <li class="breadcrumb-item active mx-1" >
            قائمة اسر الشهداء
            </li>
          </ol>
        </nav>

        <hr>

        @php $totalRealMembers = 0; $totalMembers = 0; @endphp


        <div class="d-flex justify-content-between align-items-center px-3">
          <h4> قائمة اسر الشهداء</h4>
          <div class="d-flex justify-content-between align-items-center ">
               @if (request()->query('show') != 'true')
              <a class="btn btn-success active" href="{{ request()->url() . '?show=true' }}" >
                <i class="bi bi-menu-app ml-2"></i>
                عرض الكل
              </a>
            @else
              <a class="btn btn-info active" href="{{ request()->url() . '?show=false' }}" >
                <i class="bi bi-x ml-2"></i>
                إخفاء الكل
              </a>
            @endif
            

                       
            @if (request()->query('show') == 'true')
              
              {{-- Show btns --}}
                @if (is_null(request()->query('hiddenNotesAndActions')) || request()->query('hiddenNotesAndActions') == 'true')
                  <a class="btn btn-info active  mr-2" href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'false']) }}" >
                    <i class="bi bi-eye-slash ml-2"></i>
                    إخفاء ازرار العمليات
                  </a>
                @else
                  <a class=" mr-2 btn btn-success active " href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'true']) }}" >
                    <i class="bi bi-eye ml-2"></i>
                      عرض ازرار العمليات
                  </a>
                @endif
              {{--/ Show btns --}}

            @endif

            <button class="mx-4 btn  btn-primary active" onclick="printContainer()">
              <i class="bi bi-printer ml-2"></i>
                طباعة 
            </button>
            
          </div>
        </div>

        <hr>

        <div class="search-form mx-2">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row px-1 mt-4">

              <input type="hidden" name="show" value="true">
              
              <div class="col-2">
                <label>بحث باستخدام :</label>
                <div class="form-group">
                    <select name="search" class="form-select">
                      <option value="">--- </option>
                      <option value="martyr_name" @selected(request('search') == 'martyr_name')>اسم  الشهيد</option>
                      <option value="force" @selected(request('search') == 'force')>القوة  الشهيد</option>
                      <option value="militarism_number" @selected(request('search') == 'militarism_number')>النمرة العسكرية</option>
                    </select>
                  </div>
              </div>

              <div class="col-2">
                <label>بحث عن  : </label>
                <div class="form-group">
                  <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
                </div>
              </div>


                    
              <div class="col-2">
                <label> الشريحة :</label>
                <div class="form-group">
                    <select name="category" class="form-select">
                      <option value="all">الكل</option>
                       @foreach(['أرملة و ابناء','أب و أم و أخوان و أخوات','أخوات','مكتفية'] as $category)
                          <option value="{{ $category }}" @selected(request()->query('category') == $category)>{{ $category }}</option>
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


              <div class="col-2  d-flex align-items-center">
                <div class="mt-3 d-flex align-items-center flex-column justify-content-center mx-1">
                  <button class="btn py-4 btn-primary active form-control " title="بحث ">
                    <i class="bi bi-search ml-2"></i>
                  </button>
                </div>

                <div class=" mt-3 d-flex align-items-center flex-column justify-content-center">
                <a class="btn py-4 btn-success active form-control " title="الغاء الفلاتر" href="{{ request()->url() }}">
                    <i class="bi bi-menu-button ml-2"></i>
                  </a>
                </div>
              </div>

            </form>

            </div>
        </div>


          @if (request()->query('show') == 'true')
          <div id="printArea">
            <x-table>
            <x-slot:head>

              @if (request()->query('search') != 'martyr_name')
                <th>اسرة الشهيد</th>
              @endif

               @if (request()->query('search') != 'force')
                <th>قوة الشهيد</th>
              @endif


              @if (request()->query('category') == 'all' || !request()->query('category'))
              <th>الشريحة</th>
              @endif

              <th>عدد افراد الاسرة</th>
              <th>عدد الافراد في النظام</th>

              @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
              <th>القطاع</th>
              @endif

              @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
              <th>المحلية</th>
              @endif
              
              <th>المشرف</th>
              
              @if (is_null(request()->query('hiddenNotesAndActions')) || request()->query('hiddenNotesAndActions') == 'true')
                <th>عمليات</th>
              @endif

            </x-slot:head>

          <x-slot:body>
             @forelse($families as $family)

              <tr>

                  @if (request()->query('search') != 'martyr_name')
                    <td>{{ $family->martyr_name }}</td>
                  @endif

                    
                  @if (request()->query('search') != 'force')
                  <td>{{ $family->force }}</td>
                  @endif

                  @if (request()->query('category') == 'all' || !request()->query('category'))
                    <td>{{ $family->category }}</td>
                  @endif
  
                    
                  <td>{{ $family->family_size }}</td>
                  @php($totalMembers += $family->family_size)
                  
                  <td>{{ $family->real_members_count }}</td>
                  @php($totalRealMembers += $family->real_members_count)                
    

                   @if ( $family->sector )
                     @if ( request()->query('sector') !=  $family->sector)
                      <td>
                        {{ $family->sector ?? '-'}}
                        </td>
                      @endif
                    @else
                    <td>-</td>
                  @endif

                  @if ( $family->locality )
                    @if ( request()->query('locality') !=  $family->locality)
                      <td>
                        {{ $family->locality ?? '-'}}
                      </td>
                      @endif
                    @else
                    <td>-</td>
                  @endif

                  <td>{{ $family->supervisor_name ?? 'لا يوجد'}}</td>

                @if (is_null(request()->query('hiddenNotesAndActions')) || request()->query('hiddenNotesAndActions') == 'true')

                  <td>
                      <a href="{{ route('families.edit', $family->family_id) }}" class="btn btn-success py-1 px-2">
                        <i class="bi bi-pen" title="تعديل"></i>
                      </a>
                      <a href="{{ route('families.delete', $family->family_id) }}" class="btn btn-danger py-1 px-2">
                        <i class="bi bi-trash-fill" title="حذف"></i>
                      </a>
                      <a href="{{ route('families.show', $family->family_id) }}" class="btn btn-primary active  py-1 px-2">
                        <i class="bi bi-person-fill" title="عرض ملف الاسرة"></i>
                      </a>
                  </td>
                  @endif

              </tr>

              @empty
                  <tr>
                     <td colspan="16">لا توجد نتائج</td>
                  </tr>
              @endforelse

              <caption class="text-primary">

               @if(request()->query('search') == 'martyr_name')
                اسرة الشهيد  {{ request()->query('needel') }} -
                @endif
                
               @if(request()->query('category') != 'all' && !is_null(request()->query('category')))
                الشريحة {{ request()->query('category') }}
                @else
                  كل الشرائح
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
          
          {{ $families->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}
          
        <hr>
        
        <div class="d-flex align-items-center justify-content-between  py-4 mb-5">
          <h5>
              عدد الاسر الكلي :
              <span><b>{{ number_format($families->total()) }}</b></span>
          </h5>

        </div>

        </div>

          @else

            <div class="text-center p-5 mx-auto my-5">
              <h3>ادخل  اسم الشهيد في حقل البحث لعرضه, او اضغط على عرض الكل لعرض كل الاسر</h3>
            </div>

        @endif

        </div>

    </div>
  @include('components.footer')