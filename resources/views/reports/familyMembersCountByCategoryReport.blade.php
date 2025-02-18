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
          <h4>عدد أفراد الاسر  حسب  الشرائح المكفولة</h4>
           <button class="mx-4 btn btn-primary active" onclick="printTable()">
                <i class="bi bi-printer ml-2"></i>
                طباعة 
              </button>
        </div>
        <hr>

        {{-- search form --}}
        <x-search-form />
        {{-- search form --}}
       

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
                @else 
                  0%
                @endif
              </td>
              
              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(2)))
                    {{ round(($report->get(2)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                  @else 
                  0%
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(3)))
                    {{ round(($report->get(3)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                  @else 
                  0%
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(4)))
                    {{ round(($report->get(4)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                  @else 
                  0%
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(5)))
                    {{ round(($report->get(5)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                  @else 
                  0%
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(6)))
                    {{ round(($report->get(6)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                  @else 
                  0%
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(7)))
                    {{ round(($report->get(7)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                  @else 
                  0%
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(8)))
                    {{ round(($report->get(8)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                  @else 
                  0%
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(9)))
                    {{ round(($report->get(9)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                  @else 
                  0%
                @endif
              </td>

              <td>
                @if ($totalCount > 0)
                  @if (!is_null($report->get(10)))
                    {{ round(($report->get(10)[0]->count / $totalCount) * 100, 2) . '%' }}
                  @else
                    0%
                  @endif
                  @else 
                  0%
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

            <caption class="text-primary">
              عدد أفراد الاسر حسب الشرائح المكفولة 
              @if(request()->query('sector') != 'all' && !is_null(request('sector')))
                {{ request()->query('sector') }}
              @else
              كل القطاعات
              @endif

              @if( request()->query('locality') == 'all' && !is_null(request('sector')))
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

  @include('components.footer')