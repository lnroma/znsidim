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
                    </div>
                </center>
                <div class="container">
                    {{ $game->description_bottom }}
                </div>
            </div>
            <script type="text/javascript" src="https://unpkg.com/jsnes@0.1.0/dist/jsnes.min.js"></script>

            <script type="text/javascript">
                window.onload = function () {
                    // Initialize and set up outputs
                    var nes = new jsnes.NES({
                        onFrame: function(frameBuffer) {

                        },
                        onAudio: function(audioBuffer) {
                        }
                    });

                    nes.loadROM();

                    nes.frame();
                }
            </script>
        </div>
    </div>
@endsection
