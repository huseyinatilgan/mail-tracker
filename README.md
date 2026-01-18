# 🎯 MailTracker – Sales Timing Signal for B2B Teams

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20.svg?style=flat-square&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC.svg?style=flat-square&logo=tailwind-css&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)

---

## ⚡ The One-Liner
> **"MailTracker turns email opens into high-fidelity sales signals so you know exactly when to pick up the phone."**

---

## Stop Chasing Cold Leads.
MailTracker is **not** an "email analytics tool". It is a **Sales Timing Signal**.

Most trackers distract you with vanity metrics (counting bots as people). MailTracker uses advanced signal processing to filter out noise, providing you with **True Buying Signals**.

### The Promise
Call your lead the moment they open your proposal, and your conversion rate triples.

---

## 🏆 Differentiation
**"Unlike HubSpot or Streak, who count every bot as a lead, MailTracker filters out the noise to give you the one true signal that actually makes you money."**

| Feature | The Outcome (Business Value) |
| :--- | :--- |
| **Buying Signal Trigger** | Detect exactly when a prospect is reading your pitch. **Call now.** |
| **Anti-Vanity Metrics** | We flag Gmail Proxies & Apple Privacy bots. **No false positives.** |
| **Real-time Engine** | 0-latency feedback loop. **Beat your competitor to the follow-up.** |
| **Privacy by Design** | No PII storage by default. **Built to reduce compliance friction, not bypass it.** |

---

## 🛠️ Signal Logic
We prioritize **Quality over Quantity**.

1.  **Smart Deduplication:** 10 refreshes in 1 minute = **1 Signal**.
2.  **Proxy Recognition:** `GoogleImageProxy` and `Apple MPP` are flagged to prevent false "Hot Lead" alerts.
3.  **Abuse Protection:** We enforce strict limits (Events/Seat) to ensure this tool is used for *Sales*, not *Spam*.

---

## 🚀 Quick Start
1.  **Create Campaign:** "SpaceX Enterprise Proposal - Q3"
2.  **Copy Pixel:** Get your unique invisible trigger code.
3.  **Embed:** Paste it into your email signature or bottom of the HTML body.
4.  **Wait for Signal:** When the webhook fires or dashboard blinks, you dial.

---

## 🛡️ Privacy & Compliance
**Default Safe.**
*   **No Personal Data:** We do not store raw IP addresses or identifiable user agents by default.
*   **Hashed Logs:** analytical data is cryptographically hashed.
*   **Compliance:** Built to reduce compliance friction (GDPR/CCPA) by minimizing data footprint.

---

## 📦 Installation (Self-Hosted)
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

# 4. Ignite
php artisan migrate
php artisan serve
```

<p align="center">
  <sub>Built for Deal Closers by <a href="https://github.com/huseyinatilgan">Hüseyin Atılgan</a></sub>
</p>
