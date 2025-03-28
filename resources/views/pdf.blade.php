<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <form action="{{ route('pdf.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mt-2">
                    <label for="">File</label>
                    <input type="file" name="file">

            </div>  
            <div class="mt-2">
                <button class="btn">Submit</button>    
            </div> 
            @session('text')
            <div>
              <h4>result</h4>
              <pre class="border p-4">
                {{ $value }}
              </pre>
            </div>
            @endsession
        </form>
    </div>
</body>
</html>