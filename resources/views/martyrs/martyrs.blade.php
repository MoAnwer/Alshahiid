@include('components.header', ['page_title' => 'الشهداء'])

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
            <li  class="mr-1 breadcrumb-item active">{!! __('martyrs.martyrs_list') !!}</li>
          </ol>
        </nav>

        <hr>

        <x-alert />


        <div class="d-flex justify-content-between align-items-center pl-3">
          <h3>{!! __('martyrs.martyrs_list') !!}</h3>
          
          <div class="d-flex justify-content-between align-items-center ">
            
            <div class="d-flex">
              <a class="btn btn-primary active ml-1" href="{{ route('martyrs.create')}}" >
            <i class="bi bi-plus-circle ml-2"></i>
              {!! __('martyrs.new_martyr') !!}
              </a>

              @if (request()->query('show') != 'true')
                <a class="btn btn-success active mx-1" href="{{ url()->current() . '?show=true' }}" >
                  <i class="bi bi-menu-app ml-2"></i>
                  عرض كل الشهداء
                </a>
              @else
                <a class="btn btn-info active" href=" {{ url()->current() . '?show=false' }} " >
                  <i class="bi bi-x ml-2"></i>
                  إخفاء كل الشهداء
                </a>
              @endif

            
          {{-- Show btns --}}
          @if(request()->query('show') == 'true' || request('search'))
            @if (is_null(request()->query('hiddenNotesAndActions')) || request()->query('hiddenNotesAndActions') == 'true')
              <a class="btn btn-info active  mr-2" href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'false']) }}" >
                <i class="bi bi-eye-slash ml-2"></i>
                إخفاء ازرار الأسر و العمليات
              </a>
            @else
              <a class=" mr-2 btn btn-success active " href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'true']) }}" >
                <i class="bi bi-eye ml-2"></i>
                  عرض ازرار الأسر و العمليات
              </a>
            @endif
          @endif
          {{--/ Show btns --}}


          <!-- <div class="d-flex align-items-end mt-5 align-items-end"> -->
            <button class="mx-4 btn  btn-primary active" onclick="printTable()">
              <i class="bi bi-printer ml-2"></i>
                طباعة 
            </button>
            <!-- </div> -->


            </div>

          </div>

        </div>

        <hr />



        <div class="search-form px-3">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row">
              
              <div class="col-2">

                <input type="hidden" name="hiddenNotesAndActions" value="false" >
                <label>بحث باستخدام :</label>
                <div class="form-group">
                    <select name="search" class="form-select">
                      <option value="all" @selected(request('search') == 'all')>--</option>
                      <option value="name" @selected(request('search') == 'name')>اسم الشهيد</option>
                      <option value="militarism_number" @selected(request('search') == 'militarism_number')>النمرة العسكرية</option>
                      <option value="record_number" @selected(request('search') == 'record_number')> رقم السجل</option>
                    </select>
                  </div>
              </div>

              <div class="col-2">
                <label>حقل البحث: </label>
                <div class="form-group">
                  <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
                </div>
              </div>

              <div class="col-2">
                <label>الرتبة</label>
                <div class="form-group">
                  <select class="form-select" name="rank">
                    <option value="all" @selected('rank' == request()->query('rank'))>الكل</option>
                  @foreach([ 'جندي','جندي أول','عريف','وكيل عريف','رقيب','رقيب أول','مساعد','مساعد أول','ملازم','ملازم أول','نقيب','رائد','مقدم','عقيد','عميد','لواء','فريق','فريق أول','مشير'] as $rank)
                  <option value="{{ $rank }}"  @selected($rank == request()->query('rank'))>{{ $rank }}</option>

                  @endforeach

                  </select>
                </div>
              </div>
                  
                <div class="col-2">
                  <label>القوة</label>
                      <div class="form-group">
                        <select class="form-select" name="force">
                          <option value="all" @selected('force' == request()->query('force'))>الكل</option>
                        @foreach(['جهاز الأمن','شرطة موحدة','قوات مسلحة','قرارات','شهداء الكرامة'] as $force)
                          <option value="{{ $force }}" @selected($force == request()->query('force'))>{{ $force }}</option>
                        @endforeach
                      </select>
                    </div>
                </div>

                <div class="col-2">
                  <label>تاريخ الاستشهاد</label>
                  <div class="form-group">
                    <input name="martyrdom_date" type="date" class="form-control py-4" value="{{ request()->query('martyrdom_date') }}" />
                  </div>				  
                </div>

                <div class="col-2">
                  <label>{{ __('martyrs.martyrdom_place')}}</label>
                  <div class="form-group">
                    <input name="martyrdom_place" class="form-control py-4" type="text" value="{{ request()->query('martyrdom_place') }}" />
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
                      <option value="all"  @selected(request('locality') == "all")>كل المحليات</option>
                      @foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
                        <option value="{{ $locality }}" @selected(request('locality') == $locality)>{{ $locality }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>
                <div class="col-2">
                  <label>الوحدة</label>
                    <div class="form-group">
                      <input name="unit" type="text" class="form-control py-4" value="{{ request()->query('unit') }}" />
                    </div>
                  </div>
                </div>
                
              <div class="col-1">
                <button class="btn py-4 btn-primary active form-control ">
                    <i class="bi bi-search ml-2"></i>
                    بحث 
                  </button>
                </div>  

              </form>

         

            </div>
        </div> {{-- search form --}}

        <hr />

        @if (request()->query('show') == 'true' || !empty(request()->query('search')))

        
          <x-table>
            <x-slot:head>

              {{-- @if(request()->query('search') != 'name') --}}
                  <th>اسم الشهيد</th>
              {{-- @endif --}}

              @if(request()->query('force') == 'all' ||  is_null(request()->query('force')))
              <th>القوة</th>                
              @endif

              @if(empty(request()->query('unit')))
                  <th>الوحدة</th>
              @endif

              @if(request()->query('rank') == 'all' ||  is_null(request()->query('rank')))
                <th>الرتبة</th>
              @endif

              @if(request()->query('search') != 'militarism_number')
                  <th>النمرة العسكرية</th>
              @endif

              @if(empty(request()->query('martyrdom_date')))
                <th>تاريخ الإستشهاد</th>
              @endif
              
              
              @if(empty(request()->query('martyrdom_place')))
                <th>مكان الإستشهاد</th>
              @endif

              <th>رقم السجل</th>
              <th>تاريخ السجل</th>
              <th>الشريحة</th>
              <th>الحقوق</th>

               @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
              <th>القطاع</th>
              @endif
            @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
              <th>المحلية</th>
            @endif
              
              @if (request()->query('hiddenNotesAndActions') == 'true' || is_null(request()->query('hiddenNotesAndActions')))
              <th>الاسرة</th>
              <th>عمليات</th>
              @endif


            </x-slot:head>

            <x-slot:body>
              @forelse ($martyrs as $martyr)
                <tr>

                  {{-- @if(request()->query('search') != 'name') --}}
                    <td>{{ $martyr->name }}</td>
                  {{-- @endif --}}

                  @if(request()->query('force') == 'all'  || is_null(request()->query('force')))
                  <td>{{ $martyr->force }}</td>
                  @endif

                  @if(empty(request()->query('unit')))
                    <td>{{ $martyr->unit }}</td>
                  @endif

                  @if(request()->query('rank') == 'all' || is_null(request()->query('rank')))
                    <td>{{ $martyr->rank }}</td>
                  @endif

                  @if(request()->query('search') != 'militarism_number')
                    <td>{{ $martyr->militarism_number }}</td>
                  @endif

                  @if(empty(request()->query('martyrdom_date')))
                    <td>{{ $martyr->martyrdom_date }}</td>
                  @endif

                  @if(empty(request()->query('martyrdom_place')))
                    <td>{{ $martyr->martyrdom_place }}</td>
                  @endif

                  <td>{{ $martyr->record_number }}</td>
                  <td>{{ $martyr->record_date }}</td>
                  <td>{{ $martyr->category ?? '-' }}</td>                  
                  <td>{{ number_format($martyr->rights) }}</td>

                  @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
                  <td>{{ $martyr->sector ?? '-' }}</td>
                  @endif
                  @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
                  <td>{{ $martyr->locality ?? '-' }}</td>
                  @endif
                  
                  @if (request()->query('hiddenNotesAndActions') == 'true' || is_null(request()->query('hiddenNotesAndActions')))
                  <td>
                  @isset($martyr->family_id)
                    <a class="btn btn-primary active p-1" href="{{ route('families.show', $martyr->family_id) }}">الاسرة</a>
                  @else 
                    <a class="btn btn-success p-1" href="{{ route('families.create', $martyr->id) }}">
                      اضافة اسرة
                    </a>
                  @endisset
                  </td>
                  <td>
                    <a href="{{ route('martyrs.edit', $martyr->id) }}" class="btn btn-success px-2" titla="تعديل">
                      <i class="bi bi-pen fa-sm"></i>
                    </a>
                    <a href="{{ route('martyrs.delete', $martyr->id) }}" class="btn btn-danger px-2"  title="حذف">
                      <i class="bi bi-trash-fill"></i>
                    </a>
                    <a href="{{ route('tazkiia.martyrDocs.index', $martyr->id) }}" class="btn btn-info px-2"  title="السيرة الذاتية للشهيد" >
                        <i class="bi bi-book"></i>
                      </a>
                    @empty ($martyr->martyr_family_id)
                      <a href="{{ route('martyrs.relateToFamilyPage', $martyr->id) }}" class="btn btn-primary active px-2"  title="ربط الشهيد باسرة اخرى">
                        <i class="bi bi-link"></i>
                      </a>
                    @endempty
                  </td>
                  @endif
                </tr>
              @empty
                <tr><td colspan="14"> لا توجد نتائج </td></tr>
              @endforelse

            <caption>
              قائمة الشهداء 
              @if(request()->query('search') == 'name')
                  الشهيد  {{ request()->query('needel') }}
              @endif

              @if(request()->query('search') == 'militarism_number')
                  نمرة عسكرية   {{ request()->query('needel') }}
              @endif

               @if(request()->query('force') == 'all')
                @if (request()->query('search') != 'name')
                  الشهداء
                @endif
              @else
                {{ request()->query('force') }}
              @endif
              
               @if(request()->query('rank') == 'all')
               كل الرتب 
              @elseif (!is_null(request()->query('rank')))
                رتبة  {{ request()->query('rank') }} 
              @endif

              @if(!empty(request()->query('unit')))
               وحدة  {{ request()->query('unit') }}  
              @endif

              @if(!empty(request()->query('martyrdom_date')))
               بتاريخ الاستشهاد   {{ request()->query('martyrdom_date') }}  
              @endif


              @if(!empty(request()->query('martyrdom_place')))
                مكان الاستشهاد   {{ request()->query('martyrdom_place') }}
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
          
          {{ $martyrs->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}
          
        @else
            <div class="text-center p-5 mx-auto my-5">
              <h3>ادخل اسم الشهيد في حقل البحث لعرضه, او اضغط على عرض كل الشهداء</h3>
            </div>
        @endif

      </div>

    </div>



  @include('components.footer')