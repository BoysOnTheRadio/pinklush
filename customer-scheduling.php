<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pink Lush Lounge</title>
  <link rel="stylesheet" href="pinklush.css">
  <style>
      .instruction-text {
          font-family: 'Poppins', sans-serif;
          font-size: 1.2rem;
          color: #333;
          margin-bottom: 2rem;
          text-align: left;
          width: 100%;
          max-width: 900px;
          padding-left: 1rem;
          font-weight: 500;
      }

      .pl-section.scheduling {
          width: 90%;
          max-width: 1200px;
          padding: 2rem;
          gap: 1.5rem;
      }

      .scheduling-grid {
          display: flex;
          flex-direction: row;
          flex-wrap: wrap;
          justify-content: center;
          align-items: flex-start;
          gap: 2rem;
          width: 100%;
      }

      .schedule-box {
          flex: 1;
          background-color: rgb(245, 235, 237);
          border-radius: 10px;
          padding: 1.5rem;
          display: flex;
          flex-direction: column;
          align-items: center;
          gap: 1rem;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
          border: 1px solid rgba(255, 105, 180, 0.2);
      }

      .schedule-box h2 {
          margin-bottom: 0.5rem;
      }

      .note-text {
          font-family: 'Poppins', sans-serif;
          font-size: 0.85rem;
          color: #666;
          margin-bottom: 1rem;
          text-align: center;
      }

      .pl-scroll-section {
          width: 100%;
          max-height: 300px;
          overflow-y: auto;
          border-radius: 8px;
          background-color: rgb(255, 240, 245);
          padding: 0.5rem;
          border: 1px solid rgba(255, 105, 180, 0.1);
      }

      .pl-scroll-section::-webkit-scrollbar {
          width: 8px;
          border-radius: 4px;
      }

      .pl-scroll-section::-webkit-scrollbar-track {
          background: rgb(255, 223, 228);
          border-radius: 4px;
      }

      .pl-scroll-section::-webkit-scrollbar-thumb {
          background: hotpink;
          border-radius: 4px;
      }

      .pl-scroll-section::-webkit-scrollbar-thumb:hover {
          background: #ff1493;
      }

      .service-provider-list,
      .time-slot-list {
          display: flex;
          flex-direction: column;
          gap: 0.5rem;
          padding: 0.5rem;
      }

      .provider-item,
      .time-slot-item {
          width: 100%;
          padding: 0.8rem 1rem;
          background-color: rgb(255, 240, 245);
          border: 1px solid rgba(255, 105, 180, 0.3);
          border-radius: 5px;
          text-align: center;
          cursor: pointer;
          font-family: 'Poppins', sans-serif;
          font-size: 1rem;
          color: #333;
          transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.2s ease;
      }

      .provider-item:hover,
      .time-slot-item:hover {
          background-color: rgb(255, 223, 228);
          border-color: hotpink;
          transform: translateY(-2px);
      }

      .provider-item.selected,
      .time-slot-item.selected {
          background-color: rgb(255, 223, 228);
          outline: 4px solid hotpink;
          transform: translateY(0);
      }

      .none-button {
          margin-top: 1rem;
          width: 80%;
      }

      .confirm-button {
          margin-top: auto;
          width: 90%;
      }

      .calendar-box {
          gap: 1.5rem;
          width: 70%;
      }

      .calendar-header {
          display: flex;
          justify-content: center;
          align-items: center;
          width: 100%;
          margin-bottom: 0.5rem;
      }

      .calendar-nav-btn {
          background: none;
          border: 1px solid hotpink;
          color: hotpink;
          padding: 0.5rem 0.8rem;
          border-radius: 5px;
          cursor: pointer;
          font-size: 1.2rem;
          font-weight: bold;
          transition: background-color 0.3s ease, color 0.3s ease;
      }

      .calendar-nav-btn:hover {
          background-color: hotpink;
          color: #fff;
      }

      .month-year {
          font-family: 'Playfair Display', serif;
          font-size: 1.5rem;
          font-weight: 600;
          color: #333;
          text-transform: uppercase;
          justify-content: center;
      }

      .calendar-grid {
          display: grid;
          max-width: 500px;
          width: 50%;
          gap: 0.5rem;
          padding: 1rem;
          background-color: rgb(255, 240, 245);
          border-radius: 8px;
          border: 1px solid rgba(255, 105, 180, 0.1);
          grid-template-columns: repeat(7, 40px); 
          gap: 0.5rem; 
          justify-items: center;
          justify-content: center;
          
      }

      .day-header {
          flex-basis: calc(100% / 7 - 0.5rem);
          text-align: center;
          font-family: 'Poppins', sans-serif;
          font-size: 0.9rem;
          font-weight: 600;
          color: hotpink;
          padding-bottom: 0.5rem;
      }

      .date-circle {
          flex-basis: calc(100% / 7 - 0.5rem);
          width: 40px;
          height: 40px;
          border-radius: 50%;
          display: flex;
          justify-content: center;
          align-items: center;
          font-family: 'Poppins', sans-serif;
          font-size: 1rem;
          font-weight: 500;
          cursor: pointer;
          border: none;
          transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
          flex-direction: column;
          gap: 0.2rem;
      }

      .date-circle.empty {
          visibility: hidden;
          cursor: default;
      }

      .date-circle.booked {
          background-color: rgb(180, 130, 140);
          color: #fff;
          cursor: not-allowed;
          display: flex;
          
      }

      .date-circle.available {
          background-color: rgb(255, 240, 245);
          color: #333;
          border: 1px solid rgba(255, 105, 180, 0.3);
      }

      .date-circle.available:hover {
          background-color: rgb(255, 223, 228);
          transform: scale(1.05);
      }

      .date-circle.selected {
          outline: 3px solid hotpink;
          background-color: rgb(255, 223, 228);
          color: #333;
      }

      .calendar-legend {
          display: flex;
          gap: 1.5rem;
          margin-top: 1rem;
          align-items: center;
      }

      .legend-item {
          display: flex;
          align-items: center;
          gap: 0.5rem;
          font-family: 'Poppins', sans-serif;
          font-size: 0.9rem;
          color: #555;
      }

      .legend-color {
          width: 15px;
          height: 15px;
          border-radius: 50%;
      }

      .legend-color.booked {
          background-color: rgb(180, 130, 140);
      }

      .legend-color.available {
          background-color: rgb(255, 240, 245);
          border: 1px solid rgba(255, 105, 180, 0.3);
      }

      .legend-label {
          font-family: 'Poppins', sans-serif;
          font-size: 0.8rem;
          color: #777;
          margin-top: 0.5rem;
      }

      @media (max-width: 1024px) {
          .scheduling-grid {
              flex-direction: column;
              align-items: center;
          }
          .schedule-box {
              max-width: 400px;
              width: 90%;
          }
          .pl-section.scheduling {
              width: 95%;
              margin: 20px auto;
          }
      }

      @media (max-width: 768px) {
          .pl-section.scheduling {
              padding: 1.5rem;
              gap: 1rem;
          }
          .schedule-box {
              padding: 1rem;
              gap: 0.8rem;
          }
          .instruction-text {
              font-size: 1rem;
              margin-bottom: 1.5rem;
          }
          #pl-header-c {
              font-size: clamp(0.9rem, 2.5vw, 1.5rem);
          }
          #pl-header-b {
              font-size: clamp(1.5rem, 4vw, 2rem);
          }
          .month-year {
              font-size: 1.2rem;
          }
          .date-circle {
              width: 35px;
              height: 35px;
              font-size: 0.9rem;
          }
          .calendar-grid {
              padding: 0.8rem;
              gap: 0.4rem;
          }
          .provider-item,
          .time-slot-item {
              font-size: 0.9rem;
              padding: 0.6rem 0.8rem;
          }
          .btn.primary {
              height: 45px;
              font-size: 1rem;
          }
      }
  </style>
</head>
<body>
  <section class="pinklush_background">
      <form class="pl-section scheduling">
          <div class="scheduling-grid">
              <div class="schedule-box service-provider-box">
                  <h2 id="pl-header-c">Select Service Provider</h2>
                  <p class="note-text">Note: If none, please select "None"</p>
                  <div class="pl-scroll-section">
                      <div class="service-provider-list"></div>
                  </div>
                  <button type="button" class="btn primary none-button" data-category="provider" data-value="none">None</button>
              </div>
              <div class="schedule-box calendar-box">
                  <h2 id="pl-header-b">Scheduling Calendar</h2>
                  <div class="calendar-header">
                      <span class="month-year" id="currentMonthYear">-MONTH-</span>
                  </div>
                  <div class="calendar-grid" id="calendarGrid">
                      <div class="day-header">Mo</div>
                      <div class="day-header">Tu</div>
                      <div class="day-header">We</div>
                      <div class="day-header">Th</div>
                      <div class="day-header">Fr</div>
                      <div class="day-header">Sa</div>
                      <div class="day-header">Su</div>
                  </div>
                  <div class="calendar-legend">
                      <div class="legend-item">
                          <span class="legend-color booked"></span>
                          <span>Fully Booked</span>
                      </div>
                      <div class="legend-item">
                          <span class="legend-color available"></span>
                          <span>Available</span>
                      </div>
                  </div>
                  <p class="legend-label">Calendar Legend</p>
              </div>
              <div class="schedule-box time-slot-box">
                  <h2 id="pl-header-c">Select Time</h2>
                  <div class="pl-scroll-section">
                      <div class="time-slot-list"></div>
                  </div>
                  <button type="submit" class="btn primary confirm-button" id="confirmScheduleBtn" disabled>Confirm Schedule</button>
              </div>
          </div>
      </form>
  </section>
  <script src="scripts/appointments/customerScheduling.js"></script>
</body>
</html>
