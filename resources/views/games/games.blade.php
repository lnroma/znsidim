@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $game->name }}</div>

        <div class="panel-body">
            <h2>Игра денди {{ $game->name }}</h2>
            <div>
                <div class="container">
                    {{ $game->description_top }}
                </div>
                <center>
                    <div id="emulator">
                        <p>Вам необходим Flash player что бы поиграть в игры!</p>
                        <br>
                        <a href="http://www.adobe.com/go/getflashplayer">
                            <img src="//www.adobe.com/images/shared/download_buttons/get_adobe_flash_player.png"
                                 alt="Get Adobe Flash player"/>
                        </a>
                    </div>
                </center>
                <div class="container">
                    {{ $game->description_bottom }}
                </div>
            </div>

            <script src="//ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>

            <script type="text/javascript">
                console.log('load2');
                var resizeOwnEmulator = function (width, height) {
                    var emulator = $('#emulator');
                    emulator.css('width', width);
                    emulator.css('height', height);
                };
                window.onload = function () {
                    console.log('testing4');

                    $(function () {
                        function embed() {
                            var emulator = $('#emulator');
                            console.log(emulator);
                            if (emulator) {
                                var flashvars =
                                {
                                    system: '{{$game->type}}',
                                    url: '{{$game->rom_url}}'
                                };
                                var params = {};
                                var attributes = {};

                                params.allowscriptaccess = 'localhost';
                                params.allowFullScreen = 'true';
                                params.allowFullScreenInteractive = 'true';

                                swfobject.embedSWF('/flash/Nesbox.swf', 'emulator', '640', '480', '11.2.0', 'flash/expressInstall.swf', flashvars, params, attributes);
                            }
                        }

                        embed();
                    });
                }
            </script>
        </div>
    </div>
@endsection
