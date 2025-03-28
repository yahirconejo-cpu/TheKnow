

// creates a job card for the applicants that displays the accepted status
// parm 1 @ status - string - applied, interviewing, waitlisted, accepted, rejected
// parm 2 @ jobTitle - string - the job title of the job
// parm 3 @ jobDescription - string - the job description of the job
// parm 4 @ container - element - the container that will hold the job cards
function createJobCardApplicant(status, jobTitle, jobDescription, container){
  
  const box = document.createElement("div");
  box.classList.add("createJobCardApplicant");

  const statusDiv = document.createElement("div");
  statusDiv.classList.add(`createJobCardStatus createJobCardApplicantStatus_${status.toLowerCase()}`);
  statusDiv.innerHTML = status;
  box.appendChild(statusDiv);

  const titleDiv = document.createElement("div");
  titleDiv.classList.add("createJobCardJobTitle");
  titleDiv.innerHTML = jobTitle;
  box.appendChild(titleDiv);

  
  const descDiv = document.createElement("div");
  descDiv.classList.add("createJobCardJobDescription");
  
  const descTextDiv = document.createElement("div");
  descTextDiv.classList.add("createJobCardJobDescriptionText");
  descTextDiv.innerHTML = jobDescription;

  const fadeDiv = document.createElement("div");
  fadeDiv.classList.add("createJobCardJobDescriptionFade");

  descDiv.appendChild(descTextDiv);
  descDiv.appendChild(fadeDiv);
  box.appendChild(descDiv);

  container.appendChild(box);
}

// creates a job card for the employers that displays the accepted status and applicant status
// parm 1 @ status - string - open,closed

function createJobCardEmployer(status, jobTitle, applicantsCount, jobDescription, container){

  const box = document.createElement("div");
  box.classList.add("createJobCardEmployer");

  const statusDiv = document.createElement("div");
  statusDiv.classList.add(`createJobCardStatus createJobCardEmployerStatus_${status.toLowerCase()}`);
  statusDiv.innerHTML = status;
  box.appendChild(statusDiv);

  const titleDiv = document.createElement("div");
  titleDiv.classList.add("createJobCardJobTitle");
  titleDiv.innerHTML = jobTitle;
  box.appendChild(titleDiv);

  const applicantDiv = document.createElement("div");
  applicantDiv.classList.add("createJobCardJobApplicants");
  applicantDiv.innerHTML = `Applicants: ${applicantsCount}`;

  const descDiv = document.createElement("div");
  descDiv.classList.add("createJobCardJobDescription");
  
  const descTextDiv = document.createElement("div");
  descTextDiv.classList.add("createJobCardJobDescriptionText");
  descTextDiv.innerHTML = jobDescription;

  const fadeDiv = document.createElement("div");
  fadeDiv.classList.add("createJobCardJobDescriptionFade");

  descDiv.appendChild(descTextDiv);
  descDiv.appendChild(fadeDiv);
  box.appendChild(descDiv);

  container.appendChild(box);

}

// creates generic job card
function createJobCardGenericCard(jobTitle, companyName, jobDescription, container){

  const box = document.createElement("div");
  box.classList.add("createJobCardGenericCard");

  const titleDiv = document.createElement("div");
  titleDiv.classList.add("createJobCardJobTitle");
  titleDiv.innerHTML = jobTitle;
  box.appendChild(titleDiv);

  const companyDiv = document.createElement("div");
  companyDiv.classList.add("createJobCardCompany");
  companyDiv.innerHTML = companyName;

  const descDiv = document.createElement("div");
  descDiv.classList.add("createJobCardJobDescription");

  const descTextDiv = document.createElement("div");
  descTextDiv.classList.add("createJobCardJobDescriptionText");
  descTextDiv.innerHTML = jobDescription;

  const fadeDiv = document.createElement("div");
  fadeDiv.classList.add("createJobCardJobDescriptionFade");

  descDiv.appendChild(descTextDiv);
  descDiv.appendChild(fadeDiv);
  box.appendChild(descDiv);

  const applyBtn = document.createElement("button");
  applyBtn.classList.add("createJobCardApplyButton");
  applyBtn.innerHTML = "Apply Now";
  box.appendChild(applyBtn);

  container.appendChild(box);
}

// adds a add more job card
// parm 1 @ container - element - the container that will hold the job cards
function createJobCardAddMoreCard(container){
  const box = document.createElement("a");
  box.setAtrribute("href", "../Search/");
  box.classList.add("createJobCardApplicationBoxAddMore");

  const pluseSign = document.createElement("div");
  pluseSign.classList.add("createJobCardApplicationBoxAddMoreSign");
  pluseSign.innerHTML = "+";

  box.appendChild(pluseSign);

  container.appendChild(box);
}

// parm 1 @ container - string - the id of the container that will hold the job cards
// parm 2 @ quryCondition - object - uses key to check if value is equle to it {"owner": "bob", "status": "accepted", "jobTitle": "Computer Science"}
function createJobCardInitialize(container, quryCondition){

  let params = new URLSearchParams(quryCondition).toString();
  
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
        let response = JSON.parse(xhr.responseText);

        let containerElement = document.getElementById(container);
        containerElement.innerHTML = "";

        response.forEach(job => {
            
        });
    }
  };
  xhr.send();
  
}