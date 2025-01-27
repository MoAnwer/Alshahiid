@include('components.header', ['page_title' => 'عدد أفراد الاسر'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>عدد أفراد الاسر</h4>
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
            <th>اب</th>
            <th>ام</th>
            <th>أرامل</th>
            <th>ابن</th>
            <th>ابنة</th>
            <th>اخ</th>
            <th>اخت</th>
            <th>الاجمالي</th>
          </x-slot:head>
			
			    <x-slot:body>
            <tr>
              <td>العدد</td>
              <td>
                @empty(!$report->get('اب'))
                  {{ $report->get('اب')[0]->count }}
                @else
                  0
                @endempty
              </td>
              <td>
                @empty(!$report->get('ام'))
                  {{ $report->get('ام')[0]->count }}
                @else
                  0
                @endempty
              </td>
              <td>
                @empty(!$report->get('زوجة'))
                {{ $report->get('زوجة')[0]->count }}
                @else
                  0
                @endempty
              </td>
              <td>
                @empty(!$report->get('ابن'))
                {{ $report->get('ابن')[0]->count }}
                @else
                  0
                @endempty
              </td>
              <td>
                @empty(!$report->get('ابنة'))
                {{ $report->get('ابنة')[0]->count }}
                @else
                  0
                @endempty
              </td>
              <td>
                @empty(!$report->get('اخ'))
                {{ $report->get('اخ')[0]->count }}
                @else
                  0
                @endempty
              </td>
              <td>
                @empty(!$report->get('اخت'))
                {{ $report->get('اخت')[0]->count }}
                @else
                  0
                @endempty
              </td>
              <td>
                @php
                $total = 
                  (empty(!$report->get('اخت')) ? $report->get('اخت')[0]->count : 0 )+
                  (empty(!$report->get('اخ')) ? $report->get('اخ')[0]->count : 0) + 
                  (empty(!$report->get('ابنة')) ? $report->get('ابنة')[0]->count : 0) + 
                  (empty(!$report->get('ام')) ? $report->get('ام')[0]->count : 0) +
                  (empty(!$report->get('اب')) ? $report->get('اب')[0]->count : 0) +
                  (empty(!$report->get('زوجة')) ? $report->get('زوجة')[0]->count : 0) +
                  (empty(!$report->get('ابن')) ? $report->get('ابن')[0]->count : 0)
                @endphp
                {{ 
                   $total
                }}
              </td>
            </tr>
            <tr>
              <td>النسبة</td>
              <td>
                @empty(!$report->get('اب'))
                  {{ round(($report->get('اب')[0]->count / $total) * 100 , 1) .'%' }}
                @else
                  0%
                @endempty
              </td>
              <td>
                @empty(!$report->get('ام'))
                  {{  round(($report->get('ام')[0]->count / $total) * 100 , 1) .'%' }}
                @else
                  0%
                @endempty
              </td>
              <td>
                @empty(!$report->get('زوجة'))
                {{  round(($report->get('زوجة')[0]->count / $total) * 100 , 1) .'%' }}
                @else
                  0%
                @endempty
              </td>
              <td>
                @empty(!$report->get('ابن'))
                {{  round(($report->get('ابن')[0]->count / $total) * 100 , 1) .'%' }}
                @else
                  0%
                @endempty
              </td>
              <td>
                @empty(!$report->get('ابنة'))
                {{  round(($report->get('ابنة')[0]->count / $total) * 100 , 1) .'%' }}
                @else
                  0%
                @endempty
              </td>
              <td>
                @empty(!$report->get('اخ'))
                {{  round(($report->get('اخ')[0]->count / $total) * 100 , 1) .'%' }}
                @else
                  0%
                @endempty
              </td>
              <td>
                @empty(!$report->get('اخت'))
                {{  round(($report->get('اخت')[0]->count / $total) * 100 , 1) .'%' }}
                @else
                  0%
                @endempty
              </td>
              <td>100%</td>
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