<?php

return [

    'application_received' => [
        'subject' => '應徵者申請的職缺:position',
        'message' => '你已收到:teacher的職缺申請職位:position 職缺分校:school',
        'action' => '參閱申請表',
    ],

    'welcome_school' => [
        'subject' => ' 歡迎使用ELT Search',
        'message' => '您好:name謝謝您註冊使用ELT Search. 祝您使用愉快.',
        'action' => '到主頁面',
    ],

    'purchase_complete' => [
        'subject' => '謝謝您購買成功',
        'message' => '您好:name您已成功訂購:package專案費用:price謝謝您的使用。',
        'action' => '查看細項',
        'you' => '您',
    ],

    'school_disabled' => [
        'subject' => '您學校帳號已被停止使用',
        'message' => '您好:name.您的學校帳號:school已暫時禁止使用，若有相關問題，請email至:services@eltsearch.com 與我們聯絡。如果此帳號持續30天無法使用的話，將永久刪除您的帳號。在帳號為禁止使用狀態時，您的刊登頁面將被隱藏。將無法使用在ELT網站上的任何功能。',
        'action' => '',
    ],

    'school_reinstated' => [
        'subject' => '您的學校帳號已被恢復',
        'message' => '您好:name您的學校帳號已能恢復使用',
        'action' => '',
    ],

    'job_post_disabled' => [
        'subject' => '您於ELT應聘貼文已被撤回',
        'message' => '您好:name您的職缺貼文已被撤回。在相關問題尚未解決之前，您的資料不會被公開看到。若有相關問題，請email至:services@eltsearch.com 與我們聯絡。請注意:此問題將不會影響您的30天使用期應徵貼文。謝謝您的使用',
        'action' => '',
    ],

    'job_post_reinstated' => [
        'subject' => '您的ELT Search應聘貼文已被恢復',
        'message' => '您好:name您的應聘貼文已恢復使用功能，能公開被檢閱且尚未過期。謝謝您的使用',
        'action' => '',
    ],
];
