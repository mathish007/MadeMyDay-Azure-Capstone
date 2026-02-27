# Troubleshooting Notes (MadeMyDay Capstone)

## Browser timeout (site can’t be reached)
Common causes:
- Load Balancer backend health is **Unhealthy**
- NSG blocking inbound TCP/80
- No service listening on port 80 (Apache not installed/running)

## NSG pitfall: Subnet vs NIC
Avoid attaching an NSG at both subnet and NIC unless you have a reason.
A NIC-level NSG with default deny can block traffic even if subnet NSG allows it.

## VMSS health probe
Prefer **HTTP probe** on port 80 with path `/`.
If probe is red, the LB will not forward traffic.

## VMSS + app config
Use Blob storage for images to keep the web tier stateless (ideal for VMSS).
