# mock-case
Mock Case

### Gereksinimler
- PHP 8.3.8 ve üstü
- Laravel 11.30.0 ve üstü
- Mysql

### Kurulum
- .env.example dosyasını .env dosyasına kopyalayarak gerekli veritabanı parametre ayarlamalarını yapıyoruz.
- extra key generator yapmaya gerek yoktur env dosyasındaki keylerle devam edebiliriz
```
composer update
```
- komutu ile composer.json'da ki gerekli paket kurulumlarını yapıyoruz
```
php artisan migrate --seed
```
- komutunu çalıştırarak gerekli migrationları ayağa kaldırıyoruz ve seederları ekliyoruz
- developer veri tabanı seederları çalıştırılmıştır ve örnek developerlar eklemiştir
- eğer bu kısımda hat aldıysanız .env dosyasındaki database keylerini gözden geçiriniz

```
php artisan serve --port=8000
```
- Projemizi 8000 portunda başlatıyoruz.(eğer farklı bir portta çalıştıracaksanız env dosyasındaki "APP_URL" keyini güncellemeni gerekmektedir.).
```
php artisan test
```
- Test sınıflarını kontrol edip projemizi başlatıyoruz

- /app/storage/json/task/task1.json
- /app/storage/json/task/task2.json
- örnek json dosyalarından servisler oluşturulmuştur.
- /data/task/{taskId} provider'ı ile sanki dışardan verileri alıyormuşuz gibi proje içerisinde basit provider eklenmiştir.
```
php artisan task:fetch
```
- TaskFetchCommand klasöründe handle fonksiyonunda verilen $url dizisi ile provider linkleri eklenmiştir. Bu linkle çoğaltılabilir istenirse json dosyaları aracılığıyla istenirse veritabanı gibi çeşitli yöntemlerle çekilebilir. 
- task_groups tablosuna aktif sprint gibi çalışması için kayıt eklenir ve bu sprintte dağıtılacak konuları tasks tablosuna atar
- task_datas tablosuna $url dizisi kadar aktarılan task verileri kaydedilir
```
php artisan task:distribute
```
- Task Groups'a ait task verileri developerlara olduğu kadar eşit seviyede bölüştürülerek task_assigneds tablosuna aktarılır
- APP_URL/task linkine giderek task gruplarını görebilirsiniz.
- Bulunan verilerin yanındaki Task Detayına tıklayarak taskın detayına gidebilir ve taskın minimum kaç haftada biteceğiyle beraber developer bazlı task detayını görebilirsiniz
- istenirse tekrardan task fetch edilip distribute edilebilir tekrar bir iş grubu oluşturulup paylaşımı yapılır.(istenirse task jsonlarn içeriği çoğaltılabilir veya TaskFetchCommand içerisindeki $url değişkenine extra providerlar eklenebilir yada aynı providerlar çoğullanarak daha fazla veri gelmesi sağlanabilir)
- **NOT: örnek verilen task mock verileri 12 kata kadar çoğullanıp algoritma test edilmiştir**
### Task Paylaştırma Algoritması
- Developerlar çekilirken veri tabanında bulunduğu haliyle şekilir sıralaması önemli değildir
- Tasklar çekilirken en küçük zorlukta olan işten itibaren sıralanarak çekilir bu önemlidir
- Her task için developer seçileceği zaman öncelikle en çok boş vakti olan developer seçilir
- Boş saati olan developeralr birden fazlaysa en düşük iş zorluğu olana öncelik verilir
- Taskların o developerda kaç saatte biteceği formülü : 
- (iş zorluğu * iş süresi / developer'in 1 saatteki zorluğu) -> saat bazında yukarı yuvarlanır küsüratlı saatler olamayacağı için
- Developerların hepsinin boş zamanı bittiyse eğer hepsini yeni haftaya geçirir
- Taskları küçükten büyüğe sıralamamızın sebebi öncelikle küçük iş yükü olan taskları bitirmektir zira 45 efordan fazla iş yüklerini haftalık bazda küçük efora sahip olan developerlar gerçekleştiremiyor
- örneğin 1 task verisinde iş yükü: 6 verilen süre : 12 saattir bunu 1 saatte 1 iş yükü bitiren developer 72 saatte bitireceği için haftalık bazda 45 saati geçtiğinden dolayı bu işe ataması yapılamamaktadır ve sıradaki developera geçilmektedir

### Test Sınıfları
- Mock servisi testleri
- Model testleri (örnek olarak developers model seçilmiştir)
- Task çekme ve örnek pattern testleri
- Task görev dağılımı testi (Örnek Developer ve Task oluşturularak)
