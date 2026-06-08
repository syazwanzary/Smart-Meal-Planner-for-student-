# 🍽️ Smart Meal Planner Optimization System

## 📋 Project Information

| Detail | Information |
|--------|-------------|
| **Project Title** | Smart Meal Planner Optimization System |
| **Course** | Operational Reaseach |
| **Semester** | June 2026 |

---

## 👥 Group Members

| No | Name | Matrix Number |
|----|------|---------------|
| 1 | Khairulamirin Bin Khairuddin | 2240235 |
| 2 | Muhammad Syazwan Bin Salzazary | 2240242 |
| 3 | Syed Wan Muhammad Syahmi Bin Syed Nasir | 2240248 |
| 4 | Muhammad Ridzuan Bin Mat Rashid| 2240241 |

---

## 🎯 Problem Statement

University students struggle to eat healthy meals due to limited budgets. This system helps students find the optimal combination of foods that meet nutrition needs while minimizing cost.

---

## 📐 Linear Programming Formulation

### Decision Variables

| Variable | Food | Cost (RM) | Calories | Protein (g) |
|----------|------|-----------|----------|-------------|
| x₁ | Rice (1 cup) | 2.00 | 200 | 4 |
| x₂ | Chicken (1 piece) | 5.00 | 250 | 25 |
| x₃ | Eggs (2 eggs) | 1.50 | 140 | 12 |
| x₄ | Vegetables (1 cup) | 2.00 | 50 | 2 |
| x₅ | Apple (1 medium) | 1.50 | 80 | 0.5 |

### Objective Function (Minimize Cost)

### Constraints

---

## 🛠️ Technologies Used

| Technology | Purpose |
|------------|---------|
| PHP 8.x | Backend logic & LP solving |
| MySQL 8.0 | Database storage |
| HTML5 & CSS3 | User interface |
| XAMPP | Local server |
| GitHub | Version control |

---

## 📂 System Features

| Feature | Status |
|---------|--------|
| Homepage with navigation | ✅ |
| Input form for budget & nutrition | ✅ |
| Food selection checkboxes | ✅ |
| LP optimization solver | ✅ |
| Results display page | ✅ |
| Save to database | ✅ |
| History page | ✅ |
| View past solutions | ✅ |
| About page with LP explanation | ✅ |

---

## 🗄️ Database Tables

| Table | Description |
|-------|-------------|
| foods | Food items with price and nutrition |
| problems | User optimization problems |
| problem_foods | Links foods to problems |
| solutions | Optimal servings for each food |
| solution_summary | Total cost, calories, protein |

---

## 🚀 How to Run

### Step 1: Install XAMPP
Download and install XAMPP from https://www.apachefriends.org/

### Step 2: Copy Project
Copy the `smart-meal-planner` folder to:


### Step 3: Start XAMPP
- Open XAMPP Control Panel
- Start Apache
- Start MySQL

### Step 4: Import Database
- Open browser: http://localhost/phpmyadmin
- Click "New" and create database: `meal_planner_db`
- Click "Import" tab
- Choose `meal_planner.sql` file
- Click "Go"

### Step 5: Run System
Open browser and go to:


---

## 🧪 How to Use

1. Click "New Meal Plan" on homepage
2. Enter problem title
3. Choose objective (Minimize Cost / Maximize Protein / Balanced)
4. Set budget (RM), calories, protein
5. Select available foods
6. Click "Find Optimal Meal Plan"
7. View your optimized meal plan
8. Check history page for saved plans

---

## 📸 Screenshots

| Screenshot | Filename |
|------------|----------|
| Homepage | screenshots/homepage.png |
| Input Form | screenshots/input_form.png |
| Results | screenshots/results.png |
| History | screenshots/history.png |

---

## 📁 Project Structure

---

## ✅ Submission Checklist

- [ ] All PHP files working
- [ ] Database exported (meal_planner.sql)
- [ ] README.md completed
- [ ] Screenshots taken
- [ ] Group names included
- [ ] Uploaded to GitHub
- [ ] Repository is public

---

## 🎤 Presentation Tips

### What to Show:
1. Problem statement (1 min)
2. LP formulation on board (2 min)
3. Live system demo (3 min)
4. Database structure (1 min)
5. GitHub repository (1 min)
6. Q&A (2 min)

### Common Questions:
- Why did you choose this problem?
- How does your solver work?
- What if no solution exists?
- Who did what in the group?

---

## 📧 Group Contact

| Name | Email |
|------|-------|
| Syazwan Zary | syazwan@student.edu |
| Ahmad Faiz | ahmad@student.edu |
| Nurul Iman | nurul@student.edu |
| Sarah Tan | sarah@student.edu |

---

**© 2026 Smart Meal Planner Team | Linear Programming Project**
