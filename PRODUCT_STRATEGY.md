# 🚀 MailTracker – Product Strategy

> **Confidential Internal Strategy Document**

## 1️⃣ Product Identity (Locked)
*   **Identity:** "Sales Timing Signal for B2B Teams"
*   **Rejected Terms:** "email analytics tool", "open rate tracker"
*   **Core Philosophy:** "Signal without action is noise."

## 2️⃣ The One-Liner
> **"MailTracker turns email opens into high-fidelity sales signals so you know exactly when to pick up the phone."**

---

## 3️⃣ Action Layer v1.1 (Turn Signal Into Action)
We are moving beyond passive dashboards. The system must push data to where sales teams live.

### Webhook System (`sales_signal_detected`)
*   **Trigger:** Fires when a unique, non-proxy open is detected and deduplicated.
*   **Payload:**
    ```json
    {
      "event": "sales_signal_detected",
      "campaign_id": "cmp_12345",
      "campaign_name": "Q3 Proposal - Acme Corp",
      "confidence_score": "high",
      "is_proxy": false,
      "occurred_at": "2026-01-18T14:30:00Z",
      "signal_strength": {
        "open_count": 3,
        "velocity": "2_opens_in_5_mins"
      }
    }
    ```
*   **Goal:** Enable direct integration with Slack, Discord, or Zapier.

---

## 4️⃣ Pricing & Technical Limits
Pricing protects signal quality by preventing spam. We sell "Signal Capacity", not "Email Volume".

### Seat-Based Limits (Enforced via Middleware)
1.  **Events per Seat:** 1,000 tracked events / day.
    *   *Why?* A human SDR cannot handle more than 50 "hot" signals a day. Higher volume implies mass marketing (spam), which kills domain reputation.
2.  **Campaigns per Seat:** 50 active campaigns.
    *   *Why?* Forces focus on high-value deals.
3.  **Rate Limits:** 60 requests/minute per seat.
    *   *Soft Throttling:* If exceeded, return 429 but queue the signal if possible (Action Layer v1.2 consideration). For now, strict 429.

> **"High volume destroys signal. We limit volume to guarantee validity."**

---

## 5️⃣ Signal Logic (No Ambiguity)
Precision is our product. We do not count noise.

### Logic Rules
1.  **Multi-Device Handling:**
    *   If `User-Agent` changes (Mobile -> Desktop) within 60 mins -> **Strong Signal** (Flag as "Device Switch").
2.  **Proxy vs. MPP:**
    *   `GoogleImageProxy`: Count as **Weak Signal** (Delivery confirmed, no intent).
    *   `Apple MPP`: Flag as `is_proxy=true`. Do NOT trigger "Hot Lead" alerts unless confirmed by a subsequent non-proxy interaction (e.g., click).
3.  **Unique Open Definition:**
    *   A "Unique Open" is a specific IP + UA hash combination.
    *   **Window:** We deduplicate clicks from the same source for **60 minutes**.
    *   *Effect:* 10 refreshes in 1 minute = 1 Signal. 2 opens 3 hours apart = 2 Signals.

---

## 6️⃣ Privacy Tone (Safe & Confident)
We do not use "hacks". We use "Privacy by Design".

*   **Bad:** "We bypass GDPR restrictions."
*   **Good:** "Built to reduce compliance friction, not bypass it."
*   **Stance:**
    *   **Default-Safe:** PII (IPs) are hashed or discarded by default.
    *   **Minimal Data:** We only store what is needed to confirm "Interest".
    *   **Configurable:** Enterprise clients can enable fuller logging if they own the liability.

---

## 7️⃣ Real Sales Scenario
1.  **Proposal Sent:** SDR sends "Enterprise_Plan_v3.pdf" to Champion at 10:00 AM.
2.  **Signal Detected:** 10:05 AM -> "Active Read" detected (non-proxy, desktop UA).
3.  **Sales Notified:** Slack bot pings SDR: "🔥 Champion is reading Enterprise_Plan_v3 right now."
4.  **Call Made:** SDR calls at 10:06 AM. "Hey, I was just reviewing your file..."
5.  **Outcome:** Objection handled immediately. **Deal moved to Contract.**

---

## 8️⃣ Scale-Ready Roadmap (Locked)

### v1.1 Webhooks (Current Focus)
*   **Action:** Send JSON payload to user-defined URL.
*   **Value:** "Build your own alerts."
*   **Complexity:** Low.

### v1.2 Slack / Discord
*   **Action:** Native OAuth integration.
*   **Value:** "Zero-setup team notifications."
*   **Complexity:** Medium.

### v2.0 CRM Push
*   **Action:** Sync "Last Active" date to HubSpot Deal.
*   **Value:** "Automated pipeline hygiene."
*   **Complexity:** High.
