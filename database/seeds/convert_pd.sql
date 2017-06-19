insert into users 
(select orgid, OrgContactName, OrgEmail, OrgUserName, OrgPW, NULL, NULL, OrgLastLogin, 0, 1, 0, NULL, OrgRegDate, OrgLastLogin from tblOrgs);

insert into organizations
(id, name, address1, address2, city, state, postalCode, email, phone, contactName, url, logoUrl, description)
select 
orgid, orgname, orgaddress1, orgaddress2, orgcity, orgstate, orgzip, orgemail, orgphone, orgcontactname, orgurl, orgheaderurl,
orgdesc
from tblOrgs;

insert into organization_user (organization_id, user_id, role_id, created_at, updated_at)
select id, id, 2, current_timestamp(), current_timestamp() from organizations;
  
insert into venues
(name, streetAddress, addressLocality, addressRegion, postalCode, created_by, event_id, created_at, updated_at)
select  EventVenueName, EventStreet, EventCity, EventState, EventZip, OrgID, EventID, current_timestamp(), current_timestamp()
from tblEvents;

 insert into events
 (id, organization_id, name, startDate, endDate, timeInfo,  description,
  category, contactName, phone, email, url, ticketInfo, free, 
  imageUrl, flyerUrl, ticketUrl, altMapUrl,
  published, tags,  created_at, updated_at)
select EventID, OrgID, EventName, EventStart, EventEnd, EventTimeDesc,  EventDesc,
  EventCategory, EventContactName, EventPhone, EventEmail, EventURL, EventTickets, EventFree, 
  EventImageURL,EventPrURL,EventTicketURL, EventAltMapURL,
  PageVis, EventTags, EventEntryTimestamp, EventLastEdit
from tblEvents;


UPDATE events ev,
(   SELECT id, event_id 
    FROM venues 
) ve
SET ev.venue_id = ve.id
WHERE ve.event_id = ev.id;    

insert into aggregates (aggregator_id, aggregatee_id)
select id, id from organizations;

insert into aggregates (aggregator_id, aggregatee_id)
values (135, 797);
insert into aggregates (aggregator_id, aggregatee_id)
values (135, 780);
insert into aggregates (aggregator_id, aggregatee_id)
values (135, 785);


  
  
  