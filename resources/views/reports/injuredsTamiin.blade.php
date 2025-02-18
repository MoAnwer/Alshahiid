@include('components.header', ['page_title' => 'التأمين الصحي بالمعاقين'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <h4>التأمين الصحي بالمعاقين</h4>
        <button class="mx-4 btn  btn-primary active" onclick="printTable()">
              <i class="bi bi-printer ml-2"></i>
                طباعة 
            </button>
        <hr>

                <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row px-1 mt-4">
              
              <div class="col-5">
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

              <div class="col-5">
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

            </div>
          </form>
        </div>


        <x-table>
           <x-slot:head>
              <th>نسبة العجز</th>
              <th>العدد المؤمن</th>
              <th>غير مؤمن</th>
              <th>المجموع</th>
            </x-slot:head>
      
           <x-slot:body>
            <tr>
              <td>العدد</td>
              <td>{{ $report['has'] }}</td>
              <td>{{ $report['no'] }}</td>
              <td>{{ $report['total'] }}</td>
            </tr>
            <tr>
              <td>النسبة</td>
              <td>
                @if($report['has'] > 0)
                  {{ round(($report['has'] / $report['total']) * 100, 1) . '%'}}
                @else
                  0
                @endif
              </td>
              <td>
                @if($report['no'] > 0)
                  {{ round(($report['no'] / $report['total']) * 100, 1) . '%'}}
                @else
                  0
                @endif
              </td>
              <td>100%</td>
            </tr>

<caption> 
  التأمين الصحي بالمعاقين
  @if(request()->query('sector') != 'all' && !is_null(request()->query('sector')))
                {{ request()->query('sector') }}
              @else
              كل القطاعات
              @endif

              @if( request()->query('locality') == 'all' && !is_null(request()->query('locality'))) 
                كل المحليات
              @else
                 {{ request()->query('locality')  }}
              @endif
</caption>
           </x-slot:body>

         </x-table>
      </div>

      </div>
    </div>

  @include('components.footer')