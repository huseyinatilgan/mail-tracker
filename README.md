# 🎯 MailTracker – The Sales Signal Engine

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20.svg?style=flat-square&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC.svg?style=flat-square&logo=tailwind-css&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)

---

## Stop Chasing Cold Leads. Start Closing.

**MailTracker** is not just an "email analytics tool"—it is a **Sales Action Engine**. It exists to tell you exactly *when* to pick up the phone.

Most tracking tools lie to you with vanity metrics (counting bots as people). MailTracker uses advanced signal processing to filter out noise, providing you with **True Buying Signals**.

**The Promise:** call your lead the moment they open your proposal, and your conversion rate will triple.

---

## ⚡ Why MailTracker? (Differentiation)

> "Unlike Streak or HubSpot who count every bot as a lead, MailTracker filters out the noise to give you the one true signal that actually makes you money."

### 🏆 Benefits over Features

| Feature | The Outcome (Business Value) |
| :--- | :--- |
| **Buying Signal Trigger** | Detect exactly when a prospect is reading your pitch. **Call now.** |
| **Anti-Vanity Metrics** | We filter out Gmail Proxies & Apple Privacy bots. **Stop getting excited by fake opens.** |
| **Real-time Engine** | 0-latency feedback loop. **Beat your competitor to the follow-up.** |
| **Legal-Free Privacy** | No PII storage by default. **Use it without waiting 3 months for Legal approval.** |

---

## 🛠️ Technical Capabilities

### Intelligent Signal Processing
*   **Proxy Recognition:** Automatically flags `GoogleImageProxy` and Apple Mail Privacy Protection (MPP) pre-fetches.
*   **Smart Deduplication:** A user refreshing the same email 10 times in 1 minute = 1 Signal. 10 opens over 3 days = 10 Signals (High Intent).
*   **Abuse Resistant:** Throttled endpoints (60/min) and cryptographically secure keys prevent data tampering.

### B2B SaaS Architecture
*   **Stack:** Laravel 11, Tailwind CSS (Glassmorphism UI), MySQL 8.0+, Redis (optional).
*   **Queue-Ready:** All tracking is dispatched to background jobs for high-scale resilience.
*   **Privacy First:** IP anonymization and User-Agent hashing enabled by default.

---

## 🚀 Quick Start for Sales Teams

1.  **Create Campaign:** "SpaceX Enterprise Proposal - Q3"
2.  **Copy Pixel:** Get your unique invisible trigger code.
3.  **Embed:** Paste it into your email signature or bottom of the HTML body.
4.  **Wait for Signal:** Watch the dashboard. When it blinks, you dial.

---

## 🛡️ Privacy & Compliance ("Legal Safe")

We built MailTracker to be used by enterprise teams without the red tape.
*   **No Personal Data:** We do not store raw IP addresses or identifiable user agents by default.
*   **Hashed Logs:** All analytical data is one-way hashed.
*   **GDPR Friendly:** Compliant by design, with minimal data footprint.

---

## 📦 Installation (Self-Hosted)

### Prerequisites
*   PHP 8.2+
*   Composer
*   MySQL 8.0+

### Setup
```bash
# 1. Clone
git clone https://github.com/huseyinatilgan/mail-tracker.git
cd mail-tracker

# 2. Install
composer install
npm install && npm run build

# 3. Configure
cp .env.example .env
php artisan key:generate
# (Set your DB credentials in .env)

# 4. Ignite
php artisan migrate
php artisan serve
```

---

<p align="center">
  <sub>Built for Deal Closers by <a href="https://github.com/huseyinatilgan">Hüseyin Atılgan</a></sub>
</p>
