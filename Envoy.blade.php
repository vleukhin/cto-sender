@servers(['oborud5' => 'oborud5','front' => 'front','ant-front' => 'ant-front','doosan-exkavator' => 'doosan-exkavator','front-redstar' => 'front-redstar','sany-exkavator' => 'sany-exkavator','sdlgrus' => 'sdlgrus','zoomlion-sib' => 'zoomlion-sib'])

@setup
    $landings = [
        'doosan-exkavator' => [
            'doosan-exkavator.ru' => 'httpdocs',
        ],
        'lon-king' => [
            'lon-king.ru' => 'httpdocs',
        ],
        'ant-front' => [
            'ant-front.ru' => 'httpdocs',
        ],
        'front' => [
            'фронт-погрузчик.рф' => 'httpdocs',
        ],
        'front-redstar' => [
            'front-redstar.ru' => 'httpdocs',
        ],
        'samohod' => [
            'самоходный-кран.рф' => 'httpdocs',
        ],
        'howo-rus' => [
            'howo-rus.ru' => 'httpdocs',
        ],
        'sany-exkavator' => [
            'sany-exkavator.ru' => 'httpdocs',
        ],
        'sdlgrus' => [
            'sdlgrus.ru' => 'httpdocs',
        ],
        'zoomlion-sib' => [
            'zoomlion-sib.ru' => 'httpdocs',
        ],
        'oborud5' => [
            'оборудование5.рф' => 'httpdocs',
            'шиномонтажное.оборудование5.рф' => 'subdomains/xn--80akcgufbcebe8b6d/httpdocs',
            'сход-развал.оборудование5.рф' => 'subdomains/xn----8sbahhu4arug8b/httpdocs',
            'покрасочная-камера.оборудование5.рф' => 'subdomains/xn----7sbaba3a4adtficjqjh7hug/httpdocs',
            'автосервисное.оборудование5.рф' => 'subdomains/xn--80aealbr9aeeqjeg/httpdocs',
            'стапель.оборудование5.рф' => 'subdomains/xn--80aksoig8e/httpdocs',
            'подъемник.оборудование5.рф' => 'subdomains/xn--d1acjiigdh5h/httpdocs',
            'правка-дисков.оборудование5.рф' => 'subdomains/xn----7sbahcl2ame4bcmu/httpdocs',
            'компрессор.оборудование5.рф' => 'subdomains/xn--e1ajghcehcha/httpdocs',
            'заправка-кондиционера.оборудование5.рф' => 'subdomains/xn----7sbaabjqilqatc6bdlegto5j/httpdocs',
        ],
    ];
@endsetup

@task('update-sender-oborud5', ['on' => 'oborud5'])
    echo 'Updating sender on oborud5'
    @foreach($landings['oborud5'] as $name => $dir)
        echo 'Updating landing {{ $name }}'
        cd ~/{{ $dir }}/sender
        git pull
    @endforeach
@endtask

@task('update-sender-front', ['on' => 'front'])
    echo 'Updating sender on front'
    @foreach($landings['front'] as $name => $dir)
        echo 'Updating landing {{ $name }}'
        cd ~/{{ $dir }}/sender
        git pull
    @endforeach
@endtask

@task('update-sender-ant-front', ['on' => 'ant-front'])
echo 'Updating sender on ant-front'
@foreach($landings['ant-front'] as $name => $dir)
    echo 'Updating landing {{ $name }}'
    cd ~/{{ $dir }}/sender
    git pull
@endforeach
@endtask

@task('update-sender-doosan-exkavator', ['on' => 'doosan-exkavator'])
echo 'Updating sender on doosan-exkavator'
@foreach($landings['doosan-exkavator'] as $name => $dir)
    echo 'Updating landing {{ $name }}'
    cd ~/{{ $dir }}/sender
    git pull
@endforeach
@endtask

@task('update-sender-front-redstar', ['on' => 'front-redstar'])
echo 'Updating sender on front-redstar'
@foreach($landings['front-redstar'] as $name => $dir)
    echo 'Updating landing {{ $name }}'
    cd ~/{{ $dir }}/sender
    git pull
@endforeach
@endtask

@task('update-sender-sany-exkavator', ['on' => 'sany-exkavator'])
echo 'Updating sender on sany-exkavator'
@foreach($landings['sany-exkavator'] as $name => $dir)
    echo 'Updating landing {{ $name }}'
    cd ~/{{ $dir }}/sender
    git pull
@endforeach
@endtask

@task('update-sender-sdlgrus', ['on' => 'sdlgrus'])
echo 'Updating sender on sdlgrus'
@foreach($landings['sdlgrus'] as $name => $dir)
    echo 'Updating landing {{ $name }}'
    cd ~/{{ $dir }}/sender
    git pull
@endforeach
@endtask

@task('update-sender-zoomlion-sib', ['on' => 'zoomlion-sib'])
echo 'Updating sender on zoomlion-sib'
@foreach($landings['zoomlion-sib'] as $name => $dir)
    echo 'Updating landing {{ $name }}'
    cd ~/{{ $dir }}/sender
    git pull
@endforeach
@endtask

@story('update-sender')
    update-sender-oborud5
    update-sender-front
    update-sender-ant-front
    update-sender-doosan-exkavator
    update-sender-front-redstar
    update-sender-sany-exkavator
    update-sender-sdlgrus
    update-sender-zoomlion-sib
@endstory