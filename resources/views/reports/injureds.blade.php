@include('components.header', ['page_title' => 'تقرير نسبة العجز في مصابي العمليات'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <h4>تقرير نسبة العجز في مصابي العمليات</h4>
        <x-table>
           <x-slot:head>
              <th>نسبة العجز</th>
              <th>80-89</th>
              <th>90-100</th>
              <th>المجموع</th>
            </x-slot:head>
      
           <x-slot:body>
            <tr>
              <td>العدد</td>
              <td>{{ $report['80-89'] }}</td>
              <td>{{ $report['90-100'] }}</td>
              <td>{{ $report['total'] }}</td>
            </tr>
            <tr>
              <td>النسبة</td>
              <td>
                @if($report['80-89'] > 0)
                  {{ round(($report['80-89'] / $report['total']) * 100, 1) . '%'}}
                @else
                  0
                @endif
              </td>
              <td>
                @if($report['90-100'] > 0)
                  {{ round(($report['90-100'] / $report['total']) * 100, 1) . '%'}}
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
    </div>

  @include('components.footer')