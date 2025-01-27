@include('components.header', ['page_title' => 'تصنيف الاسر'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>تصنيف الاسر</h4>
        </div>

        <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row">
              
              <div class="col-6">
                <label>القطاع :</label>
                <div class="form-group">
                    <select name="sector" class="form-select">
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
                      @foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
                        <option value="{{ $locality }}" @selected(request('locality') == $locality)>{{ $locality }}</option>
                        @endforeach
                      </select>
                  </div>
                </div>

              <div class="col-1 mt-3 d-flex align-items-center flex-column justify-content-center">
                <button class="btn py-4 btn-primary active form-control ">
                  <i class="fas fa-search ml-2"></i>
                  بحث 
                </button>
              </div>

              </form>

            </div>
        </div> {{-- search form --}}
        
        <x-table>
          <x-slot:head>
            <th>الشريحة</th>
            <th>أ</th>
            <th>ب</th>
            <th>ج</th>
            <th>د</th>
            <th>الاجمالي</th>
          </x-slot:head>
			
			    <x-slot:body>
            <tr>
              <td>العدد</td>
              <td>
                @empty(!$report->get('أ'))
                  {{ $report->get('أ')[0]->count }}
                @else
                  0
                @endempty
              </td>
              <td>
                @empty(!$report->get('ب'))
                  {{ $report->get('ب')[0]->count }}
                @else
                  0
                @endempty
              </td>
              <td>
                @empty(!$report->get('ج'))
                {{ $report->get('ج')[0]->count }}
                @else
                  0
                @endempty
              </td>
              <td>
                @empty(!$report->get('د'))
                {{ $report->get('د')[0]->count }}
                @else
                  0
                @endempty
              </td>
              <td>
                @php
                  $total = 
                  (empty(!$report->get('أ')) ? $report->get('أ')[0]->count : 0 )+
                  (empty(!$report->get('ب')) ? $report->get('ب')[0]->count : 0) + 
                  (empty(!$report->get('ج')) ? $report->get('ج')[0]->count : 0) + 
                  (empty(!$report->get('د')) ? $report->get('د')[0]->count : 0)

                @endphp
                {{ 
                  $total
                }}
              </td>
            </tr>
            <tr>
              <td>النسبة</td>
              <td>
                @empty(!$report->get('أ'))
                  {{ round(($report->get('أ')[0]->count / $total) * 100 , 1) .'%' }}
                @else
                  0%
                @endempty
              </td>
              <td>
                @empty(!$report->get('ب'))
                  {{  round(($report->get('ب')[0]->count / $total) * 100 , 1) .'%' }}
                @else
                  0%
                @endempty
              </td>
              <td>
                @empty(!$report->get('ج'))
                {{  round(($report->get('ج')[0]->count / $total) * 100 , 1) .'%' }}
                @else
                  0%
                @endempty
              </td>
              <td>
                @empty(!$report->get('د'))
                {{  round(($report->get('د')[0]->count / $total) * 100 , 1) .'%' }}
                @else
                  0%
                @endempty
              </td>
              <td>{{ $total > 0 ? '100%' : $total.'%' }}</td>
            </tr>
            <caption>
              @empty(!request()->query('sector'))
                {{ request()->query('sector') . ' - ' . request()->query('locality')}}
              @else
              كل القطاعات
              @endempty
            </caption>
			    </x-slot:body>

		    </x-table>

      </div>
    </div>

  @include('components.footer')