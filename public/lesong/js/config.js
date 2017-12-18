var Config = {
    API_URL: '',
    // WEB_URL: 'http://localhost/2017-07/tubu_0/public',
    WEB_URL: 'http://tubu.api.livesong.cn',
    act_status: ['未发布','发布中','报名结束','活动已取消','活动结束'],
    act_type: ['跑步','旅行','骑行','登山','其他'],
    act_pay: ['AA','全包','定制'],
    act_role:[
        { key: '成员', val: 0, type: 0},
        { key: '副领队', val: 1, type: 0},
        { key: '先锋', val: 2, type: 1},
        { key: '后勤', val: 3, type: 1},
        { key: '后卫', val: 4, type: 1},
        { key: '医务', val: 5, type: 1},
        { key: '联络员', val: 6, type: 1},
        { key: '领队', val: 10, type: 0}
    ],
}