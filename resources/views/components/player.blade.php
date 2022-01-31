    <video id="video" src="" height="100%" width="100%"></video>
    <div id="controls" class="w-full flex flex-col">
        <div id="buttons" class="flex justify-between w-full">
            <div class="text-white flex">
                <button id="play"><i class="fas fa-play"></i></button>
                <p id="time"></p>
                <i class="fas fa-volume-up"></i>
                <input type="range" value="0" min="0" max="100">
            </div>
            <div>
                <button class="text-white" id="fullscreen"><i class="fas fa-expand"></i></button>
            </div>
        </div>
        <div class="video-track">
            <div class="timeline"></div>
        </div>
    </div>
