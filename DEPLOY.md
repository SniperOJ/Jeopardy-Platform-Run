目前没有管理界面的情况下暂时的题目部署方法 : 
---

1. 注册一个账号 , 通过数据库修改 users 表的 type 字段 , 修改为 1 为管理员 , 普通用户为 0
2. 管理员用户登录
3. 使用 FireFox HackerBar POST 如下数据到 URL : 
```
http://domain/challenge/create

name=sctf-formate&
flag=SniperOJ{SniperOJ}&
score=300&
type=pwn&
description=nc www.sniperoj.cn 30020&
document=&
fixing=0&
resource=http://file.sniperoj.cn:8080/oj/pwn/pwn300-sctf-formate.zip
```

字段意义解释如下 : 
```
name : 题目名称
flag : flag 的明文 (会哈希后保存于数据库)
score : 分数
type : 类型 : pwn / web / stego / misc / reverse / crypto
description : 题目描述 , 即提示 hint
document : 题目参考链接 , 数据结构如下
```
    [{"title":"PHP-Object-Injection","url":"https://www.owasp.org/index.php/PHP_Object_Injection"},]
```
fixing : 是否处于修复状态 , 默认为 0 (即正常状态 , 这个可以控制题目是否显示)
resource : 如果存在附件的题目 , 则写入附件下载地址 , 如果没有则留空
```
