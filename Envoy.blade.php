@servers(['oborud5' => 'oborud5', 'mini' => 'mini','front' => 'front','pogruz' => 'pogruz', 'ant-front' => 'ant-front'])

@setup
    $landings = [
        'oborud5' => [
            'оборудование5.рф' => 'httpdocs',
            'автосервисное.оборудование5.рф' => 'subdomains/xn--80aealbr9aeeqjeg/httpdocs',
            'компрессор.оборудование5.рф' => 'subdomains/xn--e1ajghcehcha/httpdocs',
            'стапель.оборудование5.рф' => 'subdomains/xn--80aksoig8e/httpdocs',
            'споттер.оборудование5.рф' => 'subdomains/xn--e1arcgbia/httpdocs',
            'шиномонтажное.оборудование5.рф' => 'subdomains/xn--80akcgufbcebe8b6d/httpdocs',
            'складское.оборудование5.рф' => 'subdomains/xn--80aidrcdyse/httpdocs',
            'правка-дисков.оборудование5.рф' => 'subdomains/xn----7sbahcl2ame4bcmu/httpdocs',
            'покрасочная-камера.оборудование5.рф' => 'subdomains/xn----7sbaba3a4adtficjqjh7hug/httpdocs',
            'сход-развал.оборудование5.рф' => 'subdomains/xn----8sbahhu4arug8b/httpdocs',

            'акция.оборудование5.рф' => 'subdomains/xn--80aqf2c5b/httpdocs',

            'подъемник.оборудование5.рф' => 'subdomains/xn--d1acjiigdh5h/httpdocs',

            'мск-автосервисное.оборудование5.рф' => 'subdomains/xn----8sbgaobukrrhewhfek/httpdocs',
            'мск-подъемное.оборудование5.рф' => 'subdomains/xn----htbdavleifefv6j/httpdocs',
            'мск-подъемное.оборудование5.рф' => 'subdomains/xn----htbdavleifefv6j/httpdocs',
            'мск-шиномонтажное.оборудование5.рф' => 'subdomains/xn----8sbpdikndibchbe7ay9g/httpdocs',
            'мск-грузовое.оборудование5.рф' => 'subdomains/xn----dtbcjipnubqh2a/httpdocs',
            'мск-правка-дисков.оборудование5.рф' => 'subdomains/xn-----7kcajcn6aldeo0bfpml/httpdocs',
            'мск-покрасочное.оборудование5.рф' => 'subdomains/xn----8sbprbjlfcbfohh5g/httpdocs',
            'мск-стапель.оборудование5.рф' => 'subdomains/xn----8sbpribymck8i/httpdocs',
            'мск-сход-развал.оборудование5.рф' => 'subdomains/xn-----8kcajjxtqby0ahc4d/httpdocs',
        ],
        'mini' => [
            'минитрактор5.рф' => 'httpdocs',
            'навесное.минитрактор5.рф' => 'subdomains/xn--80aeja0bdhw/httpdocs',
        ],
        'front' => [
            'фронт-погрузчик.рф' => 'httpdocs',
        ],
        'pogruz' => [
            'погрузчик5.рф' => 'httpdocs',
            'вилочный.погрузчик5.рф' => 'subdomains/xn--b1amdhkf7d7a/httpdocs',
        ],
        'ant-front' => [
            'ant-front.ru' => 'httpdocs',
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

@task('update-sender-mini', ['on' => 'mini'])
    echo 'Updating sender on mini'
    @foreach($landings['mini'] as $name => $dir)
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

@task('update-sender-pogruz', ['on' => 'pogruz'])
    echo 'Updating sender on pogruz'
    @foreach($landings['pogruz'] as $name => $dir)
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

@story('update-sender')
    update-sender-oborud5
    update-sender-mini
    update-sender-front
    update-sender-pogruz
    update-sender-ant-front
@endstory