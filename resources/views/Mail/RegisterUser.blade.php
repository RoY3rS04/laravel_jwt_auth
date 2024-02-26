@vite('resources/css/app.css')
<div class="h-screen w-screen flex items-center justify-center">
    <div class="flex flex-col items-center gap-y-3 w-[50%]">
        <p class="font-medium text-center">
            Hello, {{$user->name}} we sent you this mail because it is necessary that you confirm your email adress so you can use or app. You can do so by following the link below.
        </p>
        <a class="py-2 px-3 font-bold text-white bg-blue-600 rounded-md" href="{{env('FRONTEND_URL').'verify_email/'.$token}}">Confirm Email</a>
    </div>
</div>