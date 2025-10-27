# 📋 План разработки: Investment Portfolio Telegram Bot

## Общая архитектура

```
Laravel 11 (PHP 8.3+)
├── Telegram API (Nutgram)
├── PostgreSQL
├── Redis (кэширование + очереди)
├── Finnhub API (с fallback на Alpha Vantage)
└── Nova Admin Panel
```

---

## 🚀 Фазы разработки

### ФАЗА 1: Инфраструктура & БД (3-4 часа)

**Что делаем:**
- [x] Инициализация Laravel 11 с Docker
- [x] Конфигурация PostgreSQL
- [x] Migrations (users, stocks, user_stocks, price_history, recommendations)
- [x] Models с relationships
- [x] Enum для типов рекомендаций
- [x] Seeders для тестирования

**Что появится:**
```
app/Models/
├── User.php (telegram_id, timezone)
├── Stock.php (ticker, name)
├── UserStock.php (user_id, stock_id, quantity, purchase_price, purchase_date)
├── PriceHistory.php (stock_id, date, price)
└── Recommendation.php (user_id, stock_id, type, threshold)

database/migrations/
└── [все таблицы]
```

---

### ФАЗА 2: Telegram Webhook & Базовые команды (4-5 часов)

**Что делаем:**
- [x] Настройка Nutgram
- [x] WebhookController
- [x] Команды: `/start`, `/help`
- [x] Система команд (Command Pattern)
- [x] Обработка ошибок и логирование

**Команды для реализации:**
```
/start          - регистрация, приветствие
/help           - справка
/add            - /add AAPL 10 150.50 (опциональная дата)
/remove         - /remove AAPL 5 (опциональное кол-во)
/portfolio      - текущий портфель с расчётами
/settings       - настройки чувствительности рекомендаций
/history        - история котировок акции
```

**Архитектура:**
```
app/Telegram/
├── Commands/
│   ├── StartCommand.php
│   ├── HelpCommand.php
│   ├── AddCommand.php
│   ├── RemoveCommand.php
│   ├── PortfolioCommand.php
│   ├── SettingsCommand.php
│   └── HistoryCommand.php
├── Handlers/
│   └── CommandHandler.php
└── Responses/
    └── ResponseFormatter.php
```

---

### ФАЗА 3: Сервисный слой (5-6 часов)

**Что делаем:**
- [x] **StockService** - интеграция с Finnhub/Alpha Vantage
- [x] **PortfolioService** - расчёты (средняя цена, FIFO, прибыль/убыток)
- [x] **RecommendationService** - анализ порогов, генерация сигналов
- [x] **NotificationService** - отправка сообщений в Telegram
- [x] Кэширование в Redis

**Структура:**
```
app/Services/
├── StockService.php
│   ├── getPrice(string $ticker): float
│   ├── getPriceHistory(string $ticker, int $days): array
│   └── validateTicker(string $ticker): bool
├── PortfolioService.php
│   ├── getPortfolioValue(User $user): float
│   ├── getAveragePrice(UserStock $userStock): float
│   ├── calculateProfitLoss(UserStock $userStock): array
│   └── removeStock(User $user, string $ticker, ?int $quantity): bool
├── RecommendationService.php
│   ├── analyzePortfolio(User $user): array
│   ├── generateRecommendation(UserStock $userStock): ?string
│   └── checkThresholds(User $user): void
└── NotificationService.php
    ├── send(int $chatId, string $message): bool
    └── sendWithKeyboard(int $chatId, string $message, array $keyboard): bool
```

---

### ФАЗА 4: Планировщик & Уведомления (3-4 часа)

**Что делаем:**
- [x] Laravel Scheduler для фоновых задач
- [x] Job для проверки рекомендаций (каждые 15 мин)
- [x] Job для ежедневной сводки
- [x] Обработка ошибок и retry логика

**Scheduler (в Kernel.php):**
```php
$schedule->call(function () {
    // Проверяем рекомендации для всех пользователей
    User::chunk(100, function ($users) {
        foreach ($users as $user) {
            RecommendationChecker::dispatch($user);
        }
    });
})->everyFifteenMinutes();

$schedule->call(function () {
    // Ежедневные отчёты в 9 утра (UTC)
    DailySummaryReporter::dispatch();
})->dailyAt('09:00');
```

---

### ФАЗА 5: Админ-панель (Laravel Nova) (4-5 часов)

**Что делаем:**
- [x] Установка Nova
- [x] Resources для User, Stock, UserStock, Recommendation
- [x] Custom Actions (например, "Отправить тест-уведомление")
- [x] Метрики (кол-во пользователей, средний портфель)
- [x] Управление API-ключами

**Nova Resources:**
```
app/Nova/
├── User.php
├── Stock.php
├── UserStock.php
└── Recommendation.php
```

---

### ФАЗА 6: Тестирование & Деплой (2-3 часа)

**Что делаем:**
- [x] Mocker для API (использование Pest с фейк-ответами)
- [x] Docker Compose (app, nginx, postgres, redis)
- [x] .env конфиг
- [x] README с инструкциями

---

## 📊 Временная шкала

| Фаза | Описание | Время | Статус |
|------|---------|-------|--------|
| 1 | БД & Models | 3-4 ч | ⏳ |
| 2 | Telegram & Команды | 4-5 ч | ⏳ |
| 3 | Services & API | 5-6 ч | ⏳ |
| 4 | Scheduler & Notifications | 3-4 ч | ⏳ |
| 5 | Nova Admin | 4-5 ч | ⏳ |
| 6 | Тесты & Деплой | 2-3 ч | ⏳ |
| **ИТОГО** | | **21-27 часов** | |

---

## 🛠️ Используемые технологии

```
Backend:
- Laravel 11.x
- PHP 8.3+
- PostgreSQL 15+
- Redis 7+

Telegram:
- Nutgram (https://nutgram.dev)
- Laravel Telegram Bot SDK alternative

Admin:
- Laravel Nova (опционально, можно встроенную панель)

Testing & Mocking:
- Pest (или PHPUnit)
- HTTP Client Fake
- Mockery для API

DevOps:
- Docker & Docker Compose
- Nginx
- Supervisor для Queue Worker

API:
- Finnhub (free tier: 60 req/min)
- Alpha Vantage (fallback)
```

---

## 🚀 Приоритет реализации

**MVP (Неделя 1):**
- Фаза 1-2: БД + базовые команды
- Фаза 3: StockService + PortfolioService

**Полный функционал (Неделя 2):**
- Фаза 3-4: Рекомендации + Scheduler
- Фаза 5: Nova Admin

**Полировка (Неделя 3):**
- Фаза 6: Тесты, документация, деплой

---

## ✅ Чек-лист на конец проекта

- [ ] Telegram бот полностью функционален
- [ ] Все команды работают без ошибок
- [ ] API интеграция с fallback
- [ ] Redis кэширование работает
- [ ] Scheduler запускается и отправляет уведомления
- [ ] Nova админ-панель настроена
- [ ] Docker контейнеры готовы
- [ ] README с примерами
- [ ] Логирование и обработка ошибок