@include('components.header', ['page_title' => 'المشاريع الانتاجية'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <h4>المشاريع الانتاجية</h4>
        <hr>
        {{-- search form --}}
        <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row px-1 mt-4">
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

              <div class="col-3">
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

              <div class="col-2">
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

              <div class="col-1 mt-3 d-flex align-items-center flex-column justify-content-center">
                <button class="btn py-4 btn-primary active form-control " title="بحث ">
                  <i class="bi bi-search ml-2"></i>
                </button>
              </div>

              <div class="col-1 mt-3 d-flex align-items-center flex-column justify-content-center">
              <a class="btn py-4 btn-success active form-control " title="الغاء الفلاتر" href="{{ request()->url() }}">
                  <i class="bi bi-menu-button ml-2"></i>
                </a>
              </div>
            </form>

          </div>
      </div>

        {{-- search form --}}

        @php($total = 0)

        <x-table>
           <x-slot:head>
              <th>نسبة العجز</th>
              <th>يعمل</th>
              <th>لا يعمل</th>
              <th>المجموع</th>
            </x-slot:head>
      
           <x-slot:body>
            <tr>
              <td>العدد</td>
              <td>{{ @$report->get('يعمل')[0]->count ?? 0 }}</td>
              <td>{{ @$report->get('لا يعمل')[0]->count ?? 0  }}</td>
              <td>{{ (@$report->get('يعمل')[0]->count ?? 0) + (@$report->get('لا يعمل')[0]->count ?? 0) }}</td>
              @php($total = (@$report->get('يعمل')[0]->count ?? 0) + (@$report->get('لا يعمل')[0]->count ?? 0))
            </tr>
            <tr>
              <td>النسبة</td>
              <td>
                @if(@$report->get('يعمل')[0]->count > 0 &&  $total > 0)
                  {{ round(($report->get('يعمل')[0]->count  / $total) * 100, 1) . '%'}}
                @else
                  0
                @endif
              </td>
              <td>
                @if( @$report->get('لا يعمل')[0]->count > 0 && $total > 0)
                  {{ round(( @$report->get('لا يعمل')[0]->count  / $total ) * 100, 1) . '%'}}
                @else
                  0
                @endif
              </td>
              <td>
                @if ($total > 0)
                  100%
                @else
                  0%
                @endif
              </td>
            </tr>


            <caption class="text-primary">
              تقرير حالة المشروعات الانتاجية
               @if(request()->query('force') != 'all')
                {{ request()->query('force') }}
                @endif

              @if(request()->query('sector') != 'all' || is_null(request()->query('sector')))
                {{ request()->query('sector') }}
              @else
              كل القطاعات
              @endif

              @if( request()->query('locality') == 'all' || is_null(request()->query('locality'))) 
                كل المحليات
              @else
              {{ '-' . request()->query('locality')  }}
              @endif

               @empty(!request()->query('year'))
                {{ 'سنة ' . request()->query('year')  . (request()->query('month') != '' ?  ' شهر ' . request()->query('month') : ' لكل الشهور     ')}}
              @endempty

            </caption>



           </x-slot:body>

         </x-table>
      </div>

      </div>
    </div>

  @include('components.footer')