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
          <button class="mx-4 btn  btn-primary active" onclick="printTable()">
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
              عدد أفراد الاسر حسب الشرائح المكفولة 
              @if(request()->query('force') != 'all')
                {{ request()->query('force') }}
                @endif

              @if(request()->query('sector') != 'all' && !is_null(request()->query('sector')))
                {{ request()->query('sector') }}
              @else
              كل القطاعات
              @endif

              @if( request()->query('locality') == 'all' && !is_null(request()->query('locality'))) 
                كل المحليات
              @else
              {{ '-' . request()->query('locality')  }}
              @endif
            </caption>
			    </x-slot:body>
		    </x-table>

      </div>
    </div>

  @include('components.footer')