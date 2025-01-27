@include('components.header', ['page_title' => 'احصاء الطلاب'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>احصاء الطلاب</h4>
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
			    <th>المرحلة</th>
          <th>الإبتدائي</th>
          <th>المتوسط</th>
          <th>ثانوي</th>
          <th>جامعي</th>
          <th>فوق الجامعي</th>
          <th>المجموع</th>
        </x-slot:head>
			
			<x-slot:body>
        @php($totalCount = 0)
          <tr>
            <td>العدد</td>
            <td>
              @if (!is_null($report->get('الإبتدائي')))
                {{ $report->get('الإبتدائي')[0]->count }}
                @php($totalCount +=  $report->get('الإبتدائي')[0]->count)
              @else
              0
              @endif
            </td>
            <td>
              @if (!is_null($report->get('المتوسط')))
                {{ $report->get('المتوسط')[0]->count }}
                @php($totalCount +=  $report->get('المتوسط')[0]->count)
              @else
              0
              @endif
            </td>
            <td>
              @if (!is_null($report->get('الثانوي')))
                {{ $report->get('الثانوي')[0]->count }}
                @php($totalCount += $report->get('الثانوي')[0]->count)  
              @else
              0    
              @endif
            </td>
            <td>
              @if (!is_null($report->get('جامعي')))
                {{ $report->get('جامعي')[0]->count }}
                @php($totalCount += $report->get('جامعي')[0]->count)
              @else
              0
              @endif
            </td>
            <td>
              @if (!is_null($report->get('فوق الجامعي')))
                {{ $report->get('فوق الجامعي')[0]->count }}
                @php($totalCount += $report->get('فوق الجامعي')[0]->count) 
              @else
                0
              @endif
            </td>
            <td>
              {{ $totalCount }}
            </td>
          </tr>

          <tr>
            <td>النسبة</td>
            <td>
              @if (!is_null($report->get('الإبتدائي')) && $report->get('الإبتدائي')[0]->count > 0)
                %{{ round(($report->get('الإبتدائي')[0]->count / $totalCount) * 100,1) }}
              @else
              0
              @endif
            </td>
            <td>
              @if (!is_null($report->get('المتوسط')) && $report->get('المتوسط')[0]->count > 0)
                %{{ round(($report->get('المتوسط')[0]->count / $totalCount) * 100,1) }}
              @else
              0
              @endif
            </td>
            <td>
              @if (!is_null($report->get('الثانوي')) && $report->get('الثانوي')[0]->count > 0)
                %{{ round(($report->get('الثانوي')[0]->count / $totalCount) * 100, 1) }}
              @else
              0
              @endif
            </td>
            <td>
              @if (!is_null($report->get('جامعي')) && $report->get('جامعي')[0]->count > 0)
                %{{ round(($report->get('جامعي')[0]->count / $totalCount) * 100, 1) }}
              @else
              0
              @endif
            </td>
            <td>
              @if (!is_null($report->get('فوق الجامعي')) && $report->get('فوق الجامعي')[0]->count > 0)
                %{{ round(($report->get('فوق الجامعي')[0]->count / $totalCount) * 100, 1) }}
              @else
              0
              @endif
            </td>
            <td>100%</td>
          </tr>
          
			</x-slot:body>

		  </x-table>

    </div>

  </div>

  @include('components.footer')