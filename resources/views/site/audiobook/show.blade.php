@extends('layouts.website')

@section('content')
<div style="position:relative" class="text-center">
      <h1 class="text-center tex-white" style="position: absolute; top:40%; left:43%; color:#fff; font-size:48px">Audio Book</h1>
      <img src="/images/index/banners/library.jpg" class="img img-responsive" alt="">
</div>
      <div class="container pt-5 pb-5 mt-2">
        <a href="{{ route('audiobook.index') }}" class="btn btn-default"><i class="fa fa-ban"></i> Back</a>
          		<!-- Amplitude Player -->
		@if($audiobook->source_type == "youtube_video")
			<div class="embed-responsive embed-responsive-16by9 mw-100 mt-5 mb-5">
				<iframe class="embed-responsive-item" src="{{ youtubeEmbedFromUrl($audiobook->source_folder) }}" title="YouTube video player" frameborder="0" allow="	picture-in-picture" allowfullscreen></iframe>
			</div>
		@else
			<div id="amplitude-player">

				<!-- Left Side Player -->
				<div id="amplitude-left">
					<img data-amplitude-song-info="cover_art_url" class="cover-image"/>
					<div id="player-left-bottom">
						<div id="time-container">
							<span class="current-time">
								<span class="amplitude-current-minutes" ></span>:<span class="amplitude-current-seconds"></span>
							</span>
							<div id="progress-container">
								<input type="range" class="amplitude-song-slider"/>
								<progress id="song-played-progress" class="amplitude-song-played-progress"></progress>
								<progress id="song-buffered-progress" class="amplitude-buffered-progress" value="0"></progress>
							</div>
							<span class="duration">
								<span class="amplitude-duration-minutes"></span>:<span class="amplitude-duration-seconds"></span>
							</span>
						</div>

						<div id="control-container">
							<div id="repeat-container">
								<div class="amplitude-repeat" id="repeat"></div>
								<div class="amplitude-shuffle amplitude-shuffle-off" id="shuffle"></div>
							</div>

							<div id="central-control-container">
								<div id="central-controls">
									<div class="amplitude-prev" id="previous"></div>
									<div class="amplitude-play-pause" id="play-pause"></div>
									<div class="amplitude-next" id="next"></div>
								</div>
							</div>

							<div id="volume-container">
								<div class="volume-controls">
									<div class="amplitude-mute amplitude-not-muted"></div>
									<input type="range" class="amplitude-volume-slider"/>
									<div class="ms-range-fix"></div>
								</div>
								<div class="amplitude-shuffle amplitude-shuffle-off" id="shuffle-right"></div>
							</div>
						</div>

						<div id="meta-container">
							<span data-amplitude-song-info="name" class="song-name"></span>

							<div class="song-artist-album">
								<span data-amplitude-song-info="artist"></span>
								<span data-amplitude-song-info="album"></span>
							</div>
						</div>
					</div>
				</div>
				<!-- End Left Side Player -->

				<!-- Right Side Player -->
				<div id="amplitude-right">
					@foreach($audiobook->getAudioFiles() as $index => $file)
						<div class="song amplitude-song-container amplitude-play-pause" data-amplitude-song-index="{{ $index  }}">
							<div class="song-now-playing-icon-container">
								<div class="play-button-container">

								</div>
								<img class="now-playing" src="/img/now-playing.svg"/>
							</div>
							<div class="song-meta-data">
								<span class="song-title">{{ str_replace($audiobook->source_folder . '/', '', $file) }}</span>
								<span class="song-artist">&nbsp;</span>
							</div>
							{{-- <a href="https://switchstancerecordings.bandcamp.com/track/risin-high-feat-raashan-ahmad" class="bandcamp-link" target="_blank">
								<img class="bandcamp-grey" src="/img/bandcamp-grey.svg"/>
								<img class="bandcamp-white" src="/img/bandcamp-white.svg"/>
							</a> --}}
							<span class="song-duration"></span>
						</div>
					@endforeach
				</div>
				<!-- End Right Side Player -->
			</div>
			<!-- End Amplitdue Player -->  
		@endif
      </div>
@endsection

@if($audiobook->source_type != "youtube_video")
	@push('scripts')
		<script src="https://cdnjs.cloudflare.com/ajax/libs/amplitudejs/5.2.0/amplitude.min.js" integrity="sha512-tUb91LA+ao1NsWnlnD4zkc6B2Vy6E82/D4CSLwXZY3Y0qgW46ZwFQA6eLCPenhinLWc3yngM/0NT4TdE7AX+cw==" crossorigin="anonymous"></script>
		<script>
			let bandcampLinks = document.getElementsByClassName('bandcamp-link');

			for( var i = 0; i < bandcampLinks.length; i++ ){
				bandcampLinks[i].addEventListener('click', function(e){
					e.stopPropagation();
				});
			}

			let songElements = document.getElementsByClassName('song');

			for( var i = 0; i < songElements.length; i++ ){
				songElements[i].addEventListener('mouseover', function(){
					this.style.backgroundColor = '#00A0FF';

					this.querySelectorAll('.song-meta-data .song-title')[0].style.color = '#FFFFFF';
					this.querySelectorAll('.song-meta-data .song-artist')[0].style.color = '#FFFFFF';

					if( !this.classList.contains('amplitude-active-song-container') ){
						this.querySelectorAll('.play-button-container')[0].style.display = 'block';
					}

					this.querySelectorAll('img.bandcamp-grey')[0].style.display = 'none';
					this.querySelectorAll('img.bandcamp-white')[0].style.display = 'block';
					this.querySelectorAll('.song-duration')[0].style.color = '#FFFFFF';
				});

				/*
					Ensure that on mouseout, CSS styles don't get messed up for active songs.
				*/
				songElements[i].addEventListener('mouseout', function(){
					this.style.backgroundColor = '#FFFFFF';
					this.querySelectorAll('.song-meta-data .song-title')[0].style.color = '#272726';
					this.querySelectorAll('.song-meta-data .song-artist')[0].style.color = '#607D8B';
					this.querySelectorAll('.play-button-container')[0].style.display = 'none';
					this.querySelectorAll('img.bandcamp-grey')[0].style.display = 'block';
					this.querySelectorAll('img.bandcamp-white')[0].style.display = 'none';
					this.querySelectorAll('.song-duration')[0].style.color = '#607D8B';
				});

				/*
					Show and hide the play button container on the song when the song is clicked.
				*/
				songElements[i].addEventListener('click', function(){
					this.querySelectorAll('.play-button-container')[0].style.display = 'none';
				});
			}

			/*
				Initializes AmplitudeJS
			*/
			Amplitude.init({
				continue_next: true,
				songs: {!! json_encode($audiobook->audioJSONFiles()) !!}      
			});
		</script>
	@endpush

	@push('styles')
		<link rel="stylesheet" href="/css/amplitude.css">
		<style>
			#amplitude-player {
				max-height: auto !important;
			}
		</style>
	@endpush
@endif