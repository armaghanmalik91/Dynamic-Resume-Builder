# Dynamic Resume Builder & Job Matching Engine

An advanced, full-stack application engineered with Laravel to streamline the professional resume creation process while simultaneously integrating a smart onboarding system that connects users to ideal job postings based on targeted experience tracking.

---

## 📺 System Walkthrough & Application Interfaces

### 🌐 1. Main Landing Page & Core Navigation Hub
*An interactive gateway featuring modern navigation dropdowns, categorized template previews, a dynamic testimonial showcase, and a structured FAQ module designed to capture initial user conversions.*

<video src="./public/screenshots/20260718-1600-33.3697608.mp4" width="100%" controls></video>

---

### 🔑 2. Secure User Authentication Gateway
*The account access checkpoint supporting traditional registration, contextual logins, and OAuth-driven 'Sign Up with Google' integrations to ensure smooth onboarding.*

![User Authentication Gateway](./public/screenshots/Screenshot%202026-07-18%20211350.png)

---

### 📊 3. Core User Dashboard & Automated Job Ledger
*The principal control hub where consumers manage historical resumes and explore automated, real-time job matching systems that map career listings directly below user activity statistics.*

<video src="./public/screenshots/20260718-1618-53.3932732.mp4" width="100%" controls></video>

---

### 📈 4. Onboarding & Intelligent Experience Profiling
*A critical wizard module where users document exact industry milestones. The underlying system automatically calculates, filters, and displays specific relevant employment vacancies mapped directly to verified skills.*

![Experience Profiling](./public/screenshots/Screenshot%202026-07-18%20212608.png)

---

### 🎓 5. Conditional Academic Status Verification
*An intelligent conditional layout engine. If a user inputs less than 3 years of work experience, the platform branches out to evaluate student status, academic tiers, and learning tracking to adapt document suggestions.*

![Academic Verification](./public/screenshots/Screenshot%202026-07-18%20212830.png)

---

### 🎨 6. Filtered Resume Template Gallery
*A dedicated interface that lets users search and categorize layouts, adjusting selections instantly according to career stages and student profiles.*

![Template Gallery](./public/screenshots/Screenshot%202026-07-18%20214412.png)

---

### 🔄 7. Base Document Creation Protocol
*An interface offering flexible starting points: users can load and overwrite existing resume templates to revise details or select a fresh base layout to build from scratch.*

![Creation Protocol](./public/screenshots/Screenshot%202026-07-18%20214521.png)

---

### 📞 8. Standardized Contact Information Node
*A dedicated data-entry field for structural metadata, processing essential information like full legal names, contact numbers, and addresses.*

![Contact Information Node](./public/screenshots/Screenshot%202026-07-18%20214732.png)

---

### 🛠️ 9. Comprehensive Data Entry to Document Finalization Workflow
*A continuous video walkthrough tracking full data synchronization from contact setup to final resume building. Includes live data validation: if a user navigates away without confirming a step, a prominent "Add Missing Information" alert appears under the respective tab.*

<video src="./public/screenshots/20260718-1653-02.3159419.mp4" width="100%" controls></video>

---

### 🏛️ 10. Administrative Access Terminal
*A hardened portal reserved exclusively for platform managers. It uses an immutable, predefined root email login allowing managers to update their security passwords while blocking public signups.*

![Administrative Access Terminal](./public/screenshots/Screenshot%202026-07-18%20215935.png)

---

### ⚙️ 11. Global Admin Template Control Center
*The administrative dashboard workspace where team leads upload new designs. Uploads sync instantly, updating the consumer-side template options across the platform.*

![Admin Template Control Center](./public/screenshots/Screenshot%202026-07-18%20220245.png)

---

## 🛠️ Technological Architecture Stack
- **Backend Architecture:** Laravel Framework (PHP) implementing MVC design patterns, protected route middleware, and dynamic data validation rules.
- **Frontend Layer:** Blade Templating Engine, CSS3 Layout Modules, and Vanilla JavaScript UI controllers.
- **Database Engine:** Relational schema modeling optimized for user profiles, document states, and conditional query caching.