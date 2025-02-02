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
            <th>عدد الأفراد</th>
            <th>فرد</th>
            <th>فردين</th>
            <th>3 افراد</th>
            <th>4 افراد</th>
            <th>5 افراد</th>
            <th>6 افراد</th>
            <th>7 افراد</th>
            <th>8 افراد</th>
            <th>9 افراد</th>
            <th>10 افراد</th>
            <th>10 افراد فاكثر</th>
            <th>المجموع</th>
          </x-slot:head>

          @php($totalCount = 0)
			
			    <x-slot:body>
            <tr>
              <td>العدد</td>
              <td>
                @if (!is_null($report->get(1)))
                  {{ @$report->get(1)[0]->count }}
                  @php($totalCount += $report->get(1)[0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                @if (!is_null($report->get(2)))
                  {{ @$report->get(2)[0]->count }}
                  @php($totalCount += $report->get(2)[0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                @if (!is_null($report->get(3)))
                  {{ @$report->get(3)[0]->count }}
                  @php($totalCount += $report->get(3)[0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                @if (!is_null($report->get(4)))
                  {{ $report->get(4)[0]->count }}
                  @php($totalCount += $report->get(4)[0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                @if (!is_null($report->get(5)))
                  {{ @$report->get(5)[0]->count }}
                  @php($totalCount += $report->get(5)[0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                @if (!is_null($report->get(6)))
                  {{ @$report->get(6)[0]->count }}
                  @php($totalCount += $report->get(6)[0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                @if (!is_null($report->get(7)))
                  {{ @$report->get(7)[0]->count }}
                  @php($totalCount += $report->get(7)[0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                @if (!is_null($report->get(8)))
                  {{ @$report->get(8)[0]->count }}
                  @php($totalCount += $report->get(8)[0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                @if (!is_null($report->get(9)))
                  {{ @$report->get(9)[0]->count }}
                  @php($totalCount += $report->get(9)[0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                @if (!is_null($report->get(10)))
                  {{ @$report->get(10)[0]->count }}
                  @php($totalCount += $report->get(10)[0]->count )
                @else
                  0
                @endif
              </td>
              <td>
                {{ $moreTenMembersCount }}
                @php($totalCount += $moreTenMembersCount )
              </td>
              <td>
                {{ $totalCount }}
              </td>
            </tr>
            <tr>
              <td>النسبة</td>
              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(1)))
                    {{ round(($report->get(1)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                @endif
              </td>
              
              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(2)))
                    {{ round(($report->get(2)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(3)))
                    {{ round(($report->get(3)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(4)))
                    {{ round(($report->get(4)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(5)))
                    {{ round(($report->get(5)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(6)))
                    {{ round(($report->get(6)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(7)))
                    {{ round(($report->get(7)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(8)))
                    {{ round(($report->get(8)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(9)))
                    {{ round(($report->get(9)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(10)))
                    {{ round(($report->get(10)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                @endif
              </td>

              <td>
                @if ($totalCount > 0 && $moreTenMembersCount > 0)
                  {{ round(($moreTenMembersCount / $totalCount) * 100, 2) . '%' }}
                @else
                  0%
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  100%
                @else
                  0%
                @endif
              </td>

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