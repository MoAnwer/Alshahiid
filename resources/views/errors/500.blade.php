@include('components.header', ['page_title' => '404'])
 <div id="wrapper vh-100">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
     <div id="content w-100">	  

      @include('components.navbar')
      
      <div class="mt-4 w-100 mx-auto">
        <div class="mx-auto mt-4 w-100" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
          <h1 class="text-secondary" style="font-size: 100px">500</h1>
          <h4>خطا من جانب السيرفر</h4>
        </div>
      </div>

    </div>

</div>
@include('components.footer')