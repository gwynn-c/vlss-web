@php
    $departments = [
        'engineering' => 'Engineering',
        'art'         => 'Art',
        'design'      => 'Design',
    ];
    $grouped = collect($team)->groupBy('department');
@endphp

<section class="section team-depts" aria-labelledby="team-title">
    <div class="container">
        <p class="team-depts__intro" data-reveal>Small on purpose. The people who pitch your project are the people who build it.</p>

        <div class="team-depts__grid">
            @foreach ($departments as $key => $label)
                <div class="team-dept" data-reveal>
                    <h2 class="team-dept__name">{{ $label }}</h2>
                    <ul class="team-dept__list">
                        @forelse ($grouped->get($key, collect()) as $member)
                            <li class="team-dept__item">{{ $member['name'] }}</li>
                        @empty
                            <li class="team-dept__item team-dept__item--empty">—</li>
                        @endforelse
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</section>