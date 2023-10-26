@extends('layouts.master')

@section('title','賣場')

@section('content')
<section id="location">
    <div class="wrapper">
        
        <dic class ="location-info">
            <h3 class="sub-title">國立勤益科技大學</h3>
            <h4>地址:411030台中市太平區中山路二段57號</h4>
            <h4>電話:0423924505</h4>
            <h4>營業時間:</h4>
            星期一08:00–22:00<br>
            星期二08:00–22:00<br>
            星期三08:00–22:00<br>
            星期四08:00–22:00<br>
            星期五08:00–22:00<br>
            星期六08:00–22:00<br>
            星期日08:00–22:00<br>
        </div>
        <div class="location-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3620.1942296287816!2d121.27671427444545!3d24.85721504538914!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3468176912c5eaa7%3A0x46b0f53d5ae5cb0!2z5aSp562R57K-6IiN!5e0!3m2!1szh-TW!2stw!4v1696680829001!5m2!1szh-TW!2stw" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

    </div>
</section>
@endsection